<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Exception;


use App\Api\ApiProblem;

class QuickApiProblemException extends ApiProblemException
{
    public function __construct(
        $statusCode,
        $type,
        $details,
        \Exception $previous = null,
        array $headers = []
    )
    {
        $apiProblem = new ApiProblem(
            $statusCode,
            $type
        );
        $apiProblem->set('details', $details);
        parent::__construct($apiProblem, $previous, $headers, $statusCode);
    }
}