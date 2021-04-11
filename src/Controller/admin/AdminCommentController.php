<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/articles/{article_id}/comments")
 */
class AdminCommentController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/comment/';

    /**
     * @Route("/", name="admin_comments_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_comment/index.html.twig', [
            'controller_name' => 'AdminCommentController',
        ]);
    }

    /**
     * Edit a comment if granted required athorisation
     * 
     * @Route("/{comment_id}/edit", name="admin_comments_edit", methods={"GET", "PUT"})
     * @IsGranted("EDIT_COMMENT", "comment")
     */
    public function edit(Comment $comment): Response {
        return new Response;
    }

    /**
     * show a given comment
     * 
     * @Route("/{comment_id}", name="admin_comments_show", methods={"GET"})
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * delete a comment if granted required authorisation
     * 
     * @Route("/{comment_id}", name="admin_comments_delete", methods={"DELETE"})
     * @IsGranted("DELETE_COMMENT", "comment")
     */
    public function delete(Comment $comment): Response {
        return new Response;
    }
}
