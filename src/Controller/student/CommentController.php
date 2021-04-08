<?php

namespace App\Controller\student;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @IsGranted("EDIT_COMMENT", "comment")
     */
    public function edit(Comment $comment): Response {
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
     * @IsGranted("DELETE_COMMENT", "comment")
     */
    public function delete(Comment $comment): Response {
        return new Response;
    }

    /**
     * comment an existing comment
     * 
     * @Route("/{comment_id}/comment",name="app_comments_comment", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function comment(): Response {
        return new Response;
    }
}
