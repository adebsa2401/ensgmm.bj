<?php

namespace App\Controller\student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/articles/{article_id}/comments")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="app_comments_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * edit a comment if granted requied authorisation
     * 
     * @Route("/{comment_id}/edit",name="app_comments_edit", methods={"GET", "PUT"})
     */
    public function edit(): Response {
        return new Response;
    }

    /**
     * show a comment
     * 
     * @Route("/{comment_id}",name="app_comments_show", methods={"GET"})
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * delete a comment if granted required authorisation
     * 
     * @Route("/{comment_id}",name="app_comments_delete", methods={"DELETE"})
     */
    public function delete(): Response {
        return new Response;
    }

    /**
     * comment an existing comment
     * 
     * @Route("/{comment_id}/comment",name="app_comments_comment", methods={"POST"})
     */
    public function comment(): Response {
        return new Response;
    }
}
