<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="movie")
     */
    public function index()
    {
        // https://api.themoviedb.org/3/search/movie?api_key=e6710369433e584e8867dd1a4032b48c&language=en-US&page=1&include_adult=false&query=Little&page=1
        dump('here');die;
    }
}
