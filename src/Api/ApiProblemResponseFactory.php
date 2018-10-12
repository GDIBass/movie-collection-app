<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Api;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiProblemResponseFactory
{
    public function createResponse(ApiProblem $apiProblem)
    {
        $data = $apiProblem->toArray();

        if ( $data['type'] != 'about:blank' ) {
            $data['type'] = '/docs/api/errors#' . $data['type'];
        }

        $response = new JsonResponse(
            $data,
            $apiProblem->getStatusCode()
        );

        $response->headers->set('ContentType', 'application/problem+json');

        return $response;
    }
}