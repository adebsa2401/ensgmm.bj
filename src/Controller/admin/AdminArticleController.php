<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController
{
    /**
     * @Route("/admin/article", name="admin_article")
     */
    public function index(): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }

    /**
     * Create an article if granted required authorisation
     */
    public function create(): Response {
        return new Response;
    }

    /**
     * Edit an article if granted required authorisation
     */
    public function edit(): Response {
        return new Response;
    }

    /**
     * Show a given article
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * Create Comment entity for a given article
     */
    public function comment(): Response {
        return new Response;
    }

    /**
     * Delete a given article if granted required authorisation
     */
    public function delete(): Response {
        return new Response;
    }
}
