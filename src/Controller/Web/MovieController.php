<?php

namespace App\Controller\Web;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
