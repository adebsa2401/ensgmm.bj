<?php

namespace App\Controller\student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_articles_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    /**
     * show an article
     * 
     * @Route("/{id}",name="app_articles_show", methods={"GET"})
     */
    public function show():Response {
        return new Response;
    }

    /**
     * create Comment Entity for a given article if commentable
     * 
     * @Route("/{id}/comment",name="app_articles_comment", methods={"POST"})
     */
    public function comment():Response {
        return new Response;
    }
}
