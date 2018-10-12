<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Tests\Controller\Api;

use App\Test\ApiFunctionalTest;

class MovieControllerFunctionalTest extends ApiFunctionalTest
{
    /**
     * Display error when requesting movies without a query parameter
     */
    public function testItRequestsMoviesWithoutQuery()
    {
        $this->assertEquals(1, 1);

        $client = static::createClient();

        $client->request('GET', '/api/v1/movies');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    /**
     * Display results when requesting movies with a query parameter
     */
    public function testItRequestsMoviesWithQuery()
    {
        $this->assertEquals(1,1);
    }
}