<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Service;


use App\Api\ApiProblem;
use App\Controller\Api\BaseApiController;
use App\Exception\QuickApiProblemException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovieDb
{
    public const MOVIEDB_TYPE_MOVIE  = 'movie';
    public const MOVIEDB_TYPE_SEARCH = 'search';

    /**
     * @var string
     */
    protected $dbApiKey;

    /**
     * MovieDbApi constructor.
     * @param string $dbApiKey
     */
    public function __construct(string $dbApiKey)
    {
        $this->dbApiKey = $dbApiKey;
    }

    /**
     * Gets data from the movie DB API
     *      When using pagination we'd also want some additional params here
     *
     * @param $type
     * @param $input
     *
     * @return array
     */
    public function getMovieDbData($type, $input)
    {
        if ( $type === self::MOVIEDB_TYPE_SEARCH ) {
            return $this->sendMovieDbRequest(
                'search/movie',
                [
                    'include_adult' => false,
                    'query'         => $input
                ]
            );
        } else if ( $type === self::MOVIEDB_TYPE_MOVIE ) {
            return $this->sendMovieDbRequest(sprintf('movie/%d', $input));
        }
        # Invalid Query type.  This should never happen
        throw new QuickApiProblemException(
            400,
            ApiProblem::TYPE_INVALID_PARAMS,
            "Invalid MovieDB Search Type"
        );
    }

    /**
     * Send a request to the movieDB API
     *
     *      Note this only currently supports GET, but it could be expanded to support other formats if required
     *
     * @param       $uri
     * @param array $queryParams
     *
     * @return mixed
     */
    private function sendMovieDbRequest($uri, $queryParams = [])
    {
        $client = new Client();
        try {
            # Try the request and catch failures
            $response = $client->get(
                'https://api.themoviedb.org/3/' . $uri,
                [
                    'query' => array_merge($queryParams, [
                        'api_key'  => $this->dbApiKey,
                        'language' => 'en-US',
                    ])
                ]
            );
        } catch ( RequestException $exception ) {
            # If it's a 404 we want to display that
            if ( $exception->getCode() === 404 ) {
                throw new NotFoundHttpException("MovieDB resource not found");
            }

            # If it's some other type of exception we'll display a generic error
            throw new QuickApiProblemException(
                $exception->getCode(),
                ApiProblem::TYPE_SERVICE_UNAVAILABLE,
                "An error has occurred fetching data from MovieDb, please try again later"
            );
        }

        if ( $response->getStatusCode() !== 200 ) {
            # If there was an invalid response from MovieDB
            throw new QuickApiProblemException(
                503,
                ApiProblem::TYPE_SERVICE_UNAVAILABLE,
                "MovieDB service is unavailable"
            );
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}