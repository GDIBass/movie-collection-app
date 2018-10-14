<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Controller\Api;

use App\Api\ApiProblem;
use App\Controller\BaseController;
use App\Entity\Movie;
use App\Entity\User;
use App\Exception\QuickApiProblemException;
use App\Repository\MovieRepository;
use App\Service\MovieDb;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;

/**
 * Class BaseApiController
 * @package App\Controller\Api
 */
class BaseApiController extends BaseController
{

    /** @var SerializerInterface */
    private $serializer;
    /** @var MovieDb */
    protected $movieDb;
    /** @var MovieRepository */
    private $movieRepository;

    /**
     * @param SerializerInterface $serializer
     *
     * @required
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param MovieDb $movieDb
     *
     * @required
     */
    public function setMovieDb(MovieDb $movieDb)
    {
        $this->movieDb = $movieDb;
    }

    /**
     * @param MovieRepository $movieRepository
     *
     * @required
     */
    public function setMovieRepository(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    /**
     * @param     $data
     * @param int $statusCode
     *
     * @return Response
     */
    protected function createApiResponse($data, $statusCode = 200): Response
    {
        $json = $this->serialize($data);
        $response = new Response($json, $statusCode);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * Serialize the data
     *
     * @param        $data
     * @param string $format
     *
     * @return mixed|string
     */
    protected function serialize($data, $format = 'json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->serializer->serialize($data, $format, $context);
    }

    /**
     * Gets a movie by ID ( either from the database or from movie db )
     *
     * @param $movieId
     *
     * @return Movie|Response
     */
    protected function getMovieById($movieId)
    {
        $movie = $this->movieRepository->find($movieId);

        if ( $movie ) {
            return $movie;
        }

        // Else get the movie from the db
        $rawMovie = $this->movieDb->getMovieDbData(MovieDb::MOVIEDB_TYPE_MOVIE, $movieId);

        return $this->convertRawMovieToObject($rawMovie);
    }

    /**
     * Converts Raw Movie DB data to Movie Object
     *
     * @param array $movieData
     *
     * @return Movie
     */
    protected function convertRawMovieToObject(array $movieData): Movie
    {
        try {
            return new Movie(
                $movieData['id'],
                $movieData['title'],
                new \DateTime($movieData['release_date']),
                $movieData['overview'],
                $movieData['poster_path']
            );

        } catch ( \ErrorException $exception ) {
            throw new QuickApiProblemException(
                503,
                ApiProblem::TYPE_INTERNAL_SERVER_ERROR,
                'Got Invalid data from Movie DB'
            );
        }
    }

}