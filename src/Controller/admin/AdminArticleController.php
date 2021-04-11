<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route("/admin/articles")]
class AdminArticleController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/article/';

    #[Route("/", name: "admin_articles_home", methods: ["GET"])]
    public function index(ArticleRepository $repo): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }

    #[Route("/create", name: "admin_articles_create", methods: ["GET", "POST"])]
    #[IsGranted("ROLE_WRITER")]
    public function create(): Response {
        return new Response;
    }

    /**
     * Edit an article if granted required authorisation
     * 
     * @Route("/{id}/edit", name="admin_articles_edit", methods={"GET", "PUT"})
     * @IsGranted("ARTICLE_EDIT", "aricle")
     */
    public function edit(Article $article): Response {
        return new Response;
    }

    /**
     * Show a given article
     * 
     * @Route("/{id}", name="admin_articles_show", methods={"GET"})
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * Create Comment entity for a given article
     * 
     * @Route("/{id}/comment", name="admin_articles_comment", methods={"POST"})
     */
    public function comment(): Response {
        return new Response;
    }

    /**
     * Delete a given article if granted required authorisation
     * 
     * @Route("/{id}", name="admin_articles_delete", methods={"DELETE"})
     * @IsGranted("ARTICLE_DELETE", "article")
     */
    public function delete(Article $article): Response {
        return new Response;
    }
}
