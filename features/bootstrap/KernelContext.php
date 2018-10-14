<?php

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Symfony\Component\Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

/**
 * Defines application features from the specific context.
 */
class KernelContext implements Context
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
        if ( $this->getContainer()->getParameter('kernel.environment') === 'test' ) {
            if ( file_exists(__DIR__ . '/../../var/data/test.sqlite') ) {
                unlink(__DIR__ . '/../../var/data/test.sqlite');
            }
            copy(__DIR__ . '/test.sqlite', __DIR__ . '/../../var/data/test.sqlite');
        } else {
            $em     = $this->getEm();
            $purger = new ORMPurger($em);
            $purger->purge();
        }
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
     *
     * @param $username
     *
     * @return User
     */
    public function thereIsAUser($username)
    {
        $em         = $this->getEm();
        $repository = $em->getRepository(User::class);
        $user       = $repository->findOneBy(['username' => $username]);

        if ( ! $user ) {
            $user = new User();
            $user->setUsername($username);
        }

        $em->persist($user);
        $em->flush();

        return $user;
    }
}
