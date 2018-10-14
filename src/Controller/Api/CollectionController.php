<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Controller\Api;

use App\Entity\Movie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CollectionController
 *
 * @package App\Controller\Api
 *
 * @Route("/api/v1/collection")
 */
class CollectionController extends BaseApiController
{
    /**
     * Gets a collection for the currently logged in user
     *
     * @Route("", name="api_get_collection", methods={"GET"})
     *
     * @return Response
     */
    public function getCollectionAction(): Response
    {
        $user = $this->getUser();
        return $this->createApiResponse($user->getMovies());
    }

    /**
     * Gets a movie from a collection
     *   returns an error if the movie is not in the user's collection
     *
     * @Route("/{id}", name="api_get_collection_movie", methods={"GET"})
     *
     * @ParamConverter("movie",
     *      class="App\Entity\Movie"
     * )
     *
     * @param Movie $movie
     *
     * @return Response
     */
    public function getMovieAction(Movie $movie = null): Response
    {
        $user = $this->getUser();

        # If movie is not in database or it is not in user's collection return an error
        if ( ! $movie || ! $user->hasMovie($movie) ) {
            $this->logger->info(
                sprintf(
                    'User %s attempted to get movie %d but that movie was not in their collection',
                    $user->getUsername(),
                    $movie ? $movie->getId() : '<null>'
                )
            );
            throw new NotFoundHttpException(
                'Movie not found in collection.'
            );
        }

        return $this->createApiResponse($movie);
    }

    /**
     * PUT a new Movie into the user's collection
     *
     * @Route("/{id}", name="api_put_collection_movie", methods={"PUT"})
     *
     * @param                        $id
     *
     * @return Response
     */
    public function putMovieAction($id): Response
    {
        $movie = $this->getMovieById($id);
        $this->em->persist($movie);

        $user = $this->getUser();

        # If the user has the movie we'll respond differently than if they are adding a new one
        if ( $user->hasMovie($movie) ) {
            $this->logger->info(
                sprintf(
                    "User %s attempted to add movie %d to their collection, but it was already present",
                    $user->getUsername(),
                    $id
                )
            );
            return $this->createApiResponse(
                [
                    'message' => "User already has movie."
                ],
                208
            );
        }

        $user->addMovie($movie);
        $this->em->flush();

        $this->logger->info(
            sprintf(
                "User %s added movie %d to their collection",
                $user->getUsername(),
                $id
            )
        );

        return $this->createApiResponse(
            [
                'message' => "Movie added to collection."
            ],
            201
        );
    }

    /**
     * DELETE a movie from the user's collection
     *
     * @Route("/{id}", name="api_delete_collection_movie", methods={"DELETE"})
     *
     * @param Movie|null $movie
     *
     * @return Response
     */
    public function deleteMovieAction(Movie $movie = null): Response
    {
        $user = $this->getUser();

        # If the user doesn't have the movie they're trying to remove then we'll respond differently
        if ( ! $movie || ! $user->hasMovie($movie) ) {
            $this->logger->info(
                sprintf(
                    "User %s attempted to remove movie %d to their collection, but it was already present",
                    $user->getUsername(),
                    $movie ? $movie->getId() : '<null>'
                )
            );
            throw new NotFoundHttpException(
                'Movie not found in collection.'
            );
        }

        $user->removeMovie($movie);
        $this->em->flush();

        $this->logger->info(
            sprintf(
                "User %s removed movie %d from their collection",
                $user->getUsername(),
                $movie->getId()
            )
        );

        return $this->createApiResponse(
            [
                'message' => "Movie removed from collection"
            ],
            204
        );
    }

}