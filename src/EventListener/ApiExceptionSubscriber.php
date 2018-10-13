<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\EventListener;

use App\Api\ApiProblem;
use App\Api\ApiProblemResponseFactory;
use App\Exception\ApiProblemException;
use App\Exception\QuickApiProblemException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /** @var bool */
    private $debug;
    /** @var ApiProblemResponseFactory */
    private $responseFactory;
    /** @var LoggerInterface */
    private $logger;

    /**
     * ApiExceptionSubscriber constructor.
     * @param                           $debug
     * @param ApiProblemResponseFactory $responseFactory
     * @param LoggerInterface           $logger
     */
    public function __construct($debug, ApiProblemResponseFactory $responseFactory, LoggerInterface $logger)
    {
        $this->debug = $debug;
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // only reply to /api URLs
        if ( strpos($event->getRequest()->getPathInfo(), '/api') !== 0 ) {
            return;
        }

        $e = $event->getException();

        $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;

        // allow 500 errors to be thrown
        if ( $this->debug && $statusCode >= 500 ) {
            return;
        }

        $this->logException($e);

        if ( $e instanceof ApiProblemException || $e instanceof QuickApiProblemException ) {
            $apiProblem = $e->getApiProblem();
        } else {
            $apiProblem = new ApiProblem(
                $statusCode
            );

            /*
             * If it's an HttpException message (e.g. for 404, 403),
             * we'll say as a rule that the exception message is safe
             * for the client. Otherwise, it could be some sensitive
             * low-level exception, which should *not* be exposed
             */
            if ( $e instanceof HttpExceptionInterface ) {
                $apiProblem->set('detail', $e->getMessage());
            }
        }

        $response = $this->responseFactory->createResponse($apiProblem);

        $event->setResponse($response);
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    /**
     * Adapted from the core Symfony exception handling in ExceptionListener
     *
     * @param \Exception $exception
     */
    private function logException(\Exception $exception)
    {
        $message = sprintf('Uncaught PHP Exception %s: "%s" at %s line %s', get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine());
        $isCritical = ! $exception instanceof HttpExceptionInterface || $exception->getStatusCode() >= 500;
        $context = array('exception' => $exception);
        if ( $isCritical ) {
            $this->logger->critical($message, $context);
        } else {
            $this->logger->error($message, $context);
        }
    }
}