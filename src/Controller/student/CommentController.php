<?php

namespace App\Controller\student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment", name="comment")
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * edit a comment if granted requied authorisation
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * show a comment
     */
    public function show():Response {
        return new Response;
    }

    /**
     * delete a comment if granted required authorisation
     */
    public function delete():Response {
        return new Response;
    }
}
