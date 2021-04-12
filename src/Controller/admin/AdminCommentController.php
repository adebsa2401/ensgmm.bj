<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

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
     * @return JsonResponse
     */
    #[Route("/{comment_id}", name: "admin_comments_show", methods: ["GET"])]
    public function show(Article $article, Comment $comment): Response {
        return new JsonResponse($comment);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{comment_id}", name: "admin_comments_edit", methods: ["PUT"])]
    #[IsGranted("EDIT_COMMENT", "comment")]
    public function edit(Article $article, Comment $comment,Request $request, EntityManagerInterface $em): Response {
        // set new comment

        $em->persist($comment);
        $em->flush();

        return new JsonResponse($comment);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{comment_id}", name: "admin_comments_delete", methods: ["DELETE"])]
    #[IsGranted("DELETE_COMMENT", "comment")]
    public function delete(Article $article, Comment $comment, EntityManagerInterface $em) {
        $em->remove($comment);
        $em->flush();

        return new JsonResponse($comment);
    }
}
