<?php

namespace App\Controller\Web;

use App\Controller\BaseController;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends BaseController
{
    /**
     * @Route("/", name="movie")
     */
    public function index()
    {
        $user = $this->getUser();

        return $this->render('index.html.twig', [
            'collection' => $user->getMovies(),
        ]);
    }
}
