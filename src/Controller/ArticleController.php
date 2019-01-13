<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        return new Response('Hello World!');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug): Response
    {
        return new Response('Hello'.$slug.'! :)');
    }
}
