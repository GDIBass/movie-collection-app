<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Exception;

use App\Api\ApiProblem;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    private $apiProblem;

    /**
     * ApiProblemException constructor.
     * @param ApiProblem $apiProblem
     * @param \Exception|null $previous
     * @param array $headers
     * @param int $code
     */
    public function __construct(ApiProblem $apiProblem, \Exception $previous = null, array $headers = [], $code = 0)
    {
        $this->apiProblem   = $apiProblem;
        $statusCode         = $apiProblem->getStatusCode();
        $message            = $apiProblem->getTitle();

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem()
    {
        return $this->apiProblem;
    }
}