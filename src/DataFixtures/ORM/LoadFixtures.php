<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\DataFixtures\ORM;


use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;

class LoadFixtures extends ContainerAwareFixture implements ORMFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function load(ObjectManager $manager)
    {
        $defaultUser = $this->loadUsers($manager);
        $this->loadMovies($defaultUser, $manager);
    }

    /**
     * @param User          $user
     * @param EntityManager $em
     *
     * @throws ORMException
     */
    private function loadMovies(User $user, EntityManager $em)
    {
        $movie1 = new Movie(
            9982,
            'Chicken Little',
            new \DateTime('2005-11-04'),
            "When the sky really is falling and sanity has flown the coop, who will rise to save the day? Together with his hysterical band of misfit friends, Chicken Little must hatch a plan to save the planet from alien invasion and prove that the world's biggest hero is a little chicken.",
            '/iLMALbInUmbNn1tHmxJEWm5MyjP.jpg'
        );
        $em->persist($movie1);
        $user->addMovie($movie1);

        $movie2 = new Movie(
            120,
            "The Lord of the Rings: The Fellowship of the Ring",
            new \DateTime("2001-12-18"),
            "Young hobbit Frodo Baggins, after inheriting a mysterious ring from his uncle Bilbo, must leave his home in order to keep it from falling into the hands of its evil creator. Along the way, a fellowship is formed to protect the ringbearer and make sure that the ring arrives at its final destination: Mt. Doom, the only place where it can be destroyed.",
            "/56zTpe2xvaA4alU51sRWPoKPYZy.jpg"
        );
        $em->persist($movie2);
        $user->addMovie($movie2);

        $movie3 = new Movie(
            2501,
            "The Bourne Identity",
            new \DateTime("2002-06-14"),
            "Wounded to the brink of death and suffering from amnesia, Jason Bourne is rescued at sea by a fisherman. With nothing to go on but a Swiss bank account number, he starts to reconstruct his life, but finds that many people he encounters want him dead. However, Bourne realizes that he has the combat and mental skills of a world-class spy—but who does he work for?",
            "/bXQIL36VQdzJ69lcjQR1WQzJqQR.jpg"
        );
        $em->persist($movie3);

        $em->flush();
    }

    /**
     * @param EntityManager $em
     *
     * @return User
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function loadUsers(EntityManager $em)
    {
        $em->createQuery('DELETE from App\Entity\User');

        $repository = $em->getRepository(User::class);

        $user = $repository->findOneBy(['username' => 'Neo']);
        if ( ! $user ) {
            $user = new User();
            $user->setUsername('Neo');
            $em->persist($user);
            $em->flush();
        }

        return $user;
    }
}