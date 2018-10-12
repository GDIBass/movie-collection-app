<?php

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Imbo\BehatApiExtension\Context\ApiContext;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class ApiFeatureContext extends ApiContext implements Context
{
    use KernelDictionary;

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

    private function getEm(): EntityManagerInterface
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        // TODO: Move file from base.sqlite to test.sqlite
        copy(__DIR__.'/../../var/data/base.sqlite', __DIR__.'/../../var/data/test.sqlite');
    }

    /**
     * @BeforeScenario @fixtures
     */
    public function loadFixtures()
    {
        $loader = new ContainerAwareLoader($this->getContainer());
        $loader->loadFromDirectory(__DIR__ . '/../../src/DataFixtures');
        $executor = new ORMExecutor($this->getEm());
        $executor->execute($loader->getFixtures(), true);
    }


    /**
     * @Given there is a user :username
     * @param $username
     * @return User
     */
    public function thereIsAUser($username)
    {
        $user = new User();
        $user->setUsername($username);

        $em = $this->getEm();
        $em->persist($user);
        $em->flush();
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
