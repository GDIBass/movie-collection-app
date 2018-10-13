<?php
/**
 * @author Matt Johnson <matt@gdibass.com>
 */

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /** @var EntityManagerInterface */
    protected $em;

    /**
     * @param EntityManagerInterface $em
     *
     * @required
     */
    public function setEm(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * TODO: Remove once the token listener / user auth has been configured
     *
     * @var UserRepository
     */
    private $userRepository;

    /**
     * TODO: Remove Once the token listener / user auth has been configured
     *
     * @param UserRepository $userRepository
     *
     * @required
     */
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * TODO: Remove this function once the token listener has been added
     *
     * @return User
     */
    protected function getUser()
    {
        $user = $this->userRepository->findOneBy(['username' => 'Neo']);

        if ( ! $user ) {
            $user = new User();
            $user->setUsername("Neo");

        }

        return $user;
    }
}