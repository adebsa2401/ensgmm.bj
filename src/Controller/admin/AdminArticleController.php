<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/articles")
 */
class AdminArticleController extends AbstractController
{
    /**
     * @Route("/", name="admin_articles_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }

    /**
     * Create an article if granted required authorisation
     * 
     * @Route("/create", name="admin_articles_create", methods={"GET", "POST"})
     */
    public function create(): Response {
        return new Response;
    }

    /**
     * Edit an article if granted required authorisation
     * 
     * @Route("/{id}/edit", name="admin_articles_edit", methods={"GET", "PUT"})
     */
    public function edit(): Response {
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
     */
    public function delete(): Response {
        return new Response;
    }
}
