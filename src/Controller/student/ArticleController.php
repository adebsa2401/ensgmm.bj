<?php

namespace App\Controller\Student;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/articles")
 */
class ArticleController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'student/article/';

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
     * @IsGranted("ARTICLE_COMMENT", "article")
     */
    public function comment(Article $article):Response {
        return new Response;
    }
}
