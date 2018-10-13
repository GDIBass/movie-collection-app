<?php

namespace App\Controller\Api;

use App\Api\ApiProblem;
use App\Exception\QuickApiProblemException;
use App\Service\MovieDb;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovieController
 *
 * @package App\Controller\Api
 *
 * @Route("/api/v1/movies")
 */
class MovieController extends BaseApiController
{

    /**
     * Gets a list of movies from the movieDB api
     *
     * @Route("", name="api_get_movies", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function getMoviesAction(Request $request)
    {
        # Query Parameter is required for movie search
        $query = $request->query->get('q', null);
        if ( ! $query ) {
            throw new QuickApiProblemException(
                400,
                ApiProblem::TYPE_INVALID_PARAMS,
                "You must submit a search query using field q, q=search"
            );
        }

        $response = $this->movieDb->getMovieDbData(MovieDb::MOVIEDB_TYPE_SEARCH, $query);

        // Trim unnecessary responses.  This would be more sophisticated with pagination
        $response['results'] = array_slice($response['results'], 0, 10, false);
        unset($response['page']);
        unset($response['total_pages']);

        return $this->createApiResponse($response, 200);
    }

    /**
     * Gets a movie by ID
     *
     * @Route("/{id}", name="api_get_movie", methods={"GET"})
     *
     * @param                 $id
     *
     * @return Response
     */
    public function getMovieAction($id)
    {
        // If movie exists in db return it
        $movie = $this->getMovieById($id);

        return $this->createApiResponse($movie);
    }
}
