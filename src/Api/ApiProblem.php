<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Api;

use Symfony\Component\HttpFoundation\Response;

/**
 * Use this to throw an API exception
 *
 * Class ApiProblem
 * @package App\Api
 */
class ApiProblem
{
    /**
     * Error types
     */
    const TYPE_VALIDATION_ERROR            = 'validation_error';
    const TYPE_INVALID_REQUEST_BODY_FORMAT = 'invalid_body_format';

    /**
     * Titles which match our error types
     *
     * @var array
     */
    private static $titles = array(
        self::TYPE_VALIDATION_ERROR            => 'There was a validation error',
        self::TYPE_INVALID_REQUEST_BODY_FORMAT => 'Invalid JSON format sent',
    );

    /** @var int */
    private $statusCode;
    /** @var null|string */
    private $type;
    /** @var mixed|string */
    private $title;
    /** @var array */
    private $extraData = array();

    /**
     * ApiProblem constructor.
     * @param      $statusCode
     * @param null $type
     */
    public function __construct($statusCode, $type = null)
    {
        $this->statusCode = $statusCode;

        if ( $type === null ) {
            // no type? The default is about:blank and the title should
            // be the standard status code message
            $type  = 'about:blank';
            $title = isset(Response::$statusTexts[$statusCode])
                ? Response::$statusTexts[$statusCode]
                : 'Unknown status code :(';
        } else {
            if ( ! isset(self::$titles[$type]) ) {
                throw new \InvalidArgumentException('No title for type ' . $type);
            }

            $title = self::$titles[$type];
        }

        $this->type  = $type;
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge(
            $this->extraData,
            array(
                'status' => $this->statusCode,
                'type'   => $this->type,
                'title'  => $this->title,
            )
        );
    }

    /**
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $this->extraData[$name] = $value;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        return $this->title;
    }
}