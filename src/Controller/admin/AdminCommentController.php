<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="admin_comment")
     */
    public function index(): Response
    {
        return $this->render('admin_comment/index.html.twig', [
            'controller_name' => 'AdminCommentController',
        ]);
    }

    /**
     * Edit a comment if granted required athorisation
     */
    public function edit(): Response {
        return new Response;
    }

    /**
     * show a given comment
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * delete a comment if granted required authorisation
     */
    public function delete(): Response {
        return new Response;
    }
}
