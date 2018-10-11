<?php

namespace App\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/", name="movie")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'MovieController',
        ]);
    }
}
