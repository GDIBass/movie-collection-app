<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Tests\Controller\Api;


use App\Controller\Api\BaseApiController;
use App\DataFixtures\ORM\LoadFixtures;
use App\Entity\Movie;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Response;

class BaseApiControllerTest extends KernelTestCase
{
    /** @var ContainerInterface */
    private $loadedContainer;
    /** @var BaseApiController */
    private $baseApiController;
    /** @var EntityManagerInterface */
    private $em;

    /**
     * @group legacy
     */
    protected function setUp()
    {
        (new DotEnv())->load(
            __DIR__ . '/../../../.env',
            __DIR__ . '/../../../.env.test'
        );
        self::bootKernel();

        $this->loadedContainer = self::$kernel->getContainer();

        $this->baseApiController = $this->loadedContainer->get(BaseApiController::class);

        $this->em = $this->loadedContainer->get('doctrine')
            ->getManager();

        $purger = new ORMPurger($this->em);
        $purger->purge();

        $fixture = new LoadFixtures();
        $fixture->load($this->em);
    }

    /**
     * @param $name
     *
     * @return \ReflectionMethod
     *
     * @throws \ReflectionException
     */
    protected static function getMethod($name)
    {
        $class  = new \ReflectionClass(BaseApiController::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /**
     * @throws \ReflectionException
     */
    public function testCreateApiResponse()
    {
        $createApiResponse = self::getMethod('createApiResponse');

        $movie = new Movie(
            123,
            'abc',
            new \DateTime(),
            'abc',
            'abc'
        );

        /** @var Response $response */
        $response = $createApiResponse->invoke(
            $this->baseApiController,
            [
                $movie
            ]
        );

        $this->assertTrue($response instanceof Response, "Response object invalid");

        $this->assertSame(
            200,
            $response->getStatusCode()
        );

        /** @var Response $responseWithDifferentCode */
        $responseWithDifferentCode = $createApiResponse->invokeArgs(
            $this->baseApiController,
            [
                $movie,
                204
            ]
        );

        $this->assertSame(
            204,
            $responseWithDifferentCode->getStatusCode()
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testSerializer()
    {
        $serialize = self::getMethod('serialize');

        $movie = new Movie(
            123,
            'abc',
            new \DateTime(),
            'abc',
            'abc'
        );

        $serialized = $serialize->invoke(
            $this->baseApiController,
            [
                $movie
            ]
        );

        $this->assertContains(
            '"id": 123,',
            $serialized
        );
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetMovieById()
    {
        $getMovieById = self::getMethod('getMovieById');

        $movieFromDb = $getMovieById->invokeArgs(
            $this->baseApiController,
            [
                9982
            ]
        );

        $this->assertTrue($movieFromDb instanceof Movie);
        $this->assertSame(9982, $movieFromDb->getId());

        $movieFromMovieDb = $getMovieById->invokeArgs(
            $this->baseApiController,
            [
                11
            ]
        );

        $this->assertTrue($movieFromMovieDb instanceof Movie);
        $this->assertSame(11, $movieFromMovieDb->getId());
    }

    /**
     * @throws \ReflectionException
     */
    public function testConvertRawMovieToObject()
    {
        $convertRawMovieToObject = self::getMethod('convertRawMovieToObject');

        $movie = $convertRawMovieToObject->invokeArgs(
            $this->baseApiController,
            [
                [
                    'id'           => 123,
                    'title'        => 'Fake',
                    'release_date' => '1985-03-06',
                    'overview'     => 'Hey there',
                    'poster_path'  => 'nope'
                ]
            ]
        );

        $this->assertTrue($movie instanceof Movie);
        $this->assertSame(123, $movie->getId());
    }
}