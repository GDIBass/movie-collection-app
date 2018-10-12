<?php

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;

require_once __DIR__.'/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class ApiFeatureContext extends ApiContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Then the response should contain :string
     * @param string $string
     */
    public function theResponseShouldContain(string $string)
    {
        assertContains(
            $string,
            $this->response->getBody()->getContents(),
            sprintf("Could not find %s in response body", $string)
        );
    }

}
