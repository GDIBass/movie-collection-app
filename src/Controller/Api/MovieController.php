<?php

namespace App\Controller\Api;

use App\Api\ApiProblem;
use App\Exception\ApiProblemException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MovieController
 * @package App\Controller\Api
 * @Route("/api/v1/movies")
 */
class MovieController extends BaseApiController
{
    /**
     * Gets a list of movies from the movieDB api
     *
     * @Route("/", name="api_get_movies")
     * @Method("GET")
     *
     * @param Request $request
     */
    public function getMoviesAction(Request $request)
    {
        $query = $request->query->get('q', null);

        if ( ! $query ) {
            $apiProblem = new ApiProblem(
                400,
                ApiProblem::TYPE_INVALID_PARAMS
            );
            $apiProblem->set('details', "You must submit a search query using field q, q=search");
            throw new ApiProblemException($apiProblem);
        }

        echo "hello";
        die;
        // https://api.themoviedb.org/3/search/movie?api_key=e6710369433e584e8867dd1a4032b48c&language=en-US&page=1&include_adult=false&query=Little&page=1
    }
}
