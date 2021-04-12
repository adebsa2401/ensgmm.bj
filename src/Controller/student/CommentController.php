<?php

namespace App\Controller\Student;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route("/articles/{article_id}/comments")]
class CommentController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'student/comment/';

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
     * @return JsonResponse
     */
    #[Route("/{comment_id}",name: "app_comments_edit", methods: ["PUT"])]
    #[IsGranted("EDIT_COMMENT", "comment")]
    public function edit(Article $article, Comment $comment, Request $request, EntityManagerInterface $em): Response {
        // set the new comment

        $em->persist($comment);
        $em->flush();

        return new JsonResponse($comment);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{comment_id}",name: "app_comments_show", methods: ["GET"])]
    public function show(Article $article, Comment $comment): Response {
        return new JsonResponse($comment);
    }

    #[Route("/{comment_id}",name: "app_comments_delete", methods: ["DELETE"])]
    #[IsGranted("DELETE_COMMENT", "comment")]
    public function delete(Article $article, Comment $comment, EntityManagerInterface $em): Response {
        $em->remove($comment);
        $em->flush();

        return new JsonResponse($comment);
    }

    #[Route("/{comment_id}/comment",name: "app_comments_comment", methods: ["POST"])]
    #[IsGranted("ROLE_USER")]
    public function comment(Article $article, Comment $comment, EntityManagerInterface $em, Request $request): Response {
        $newComment = (new Comment)
            ->setArticle($article)
            ->setParentComment($comment)
            ->setCreatedByStudent($this->getUser())
            ->setContent($request->request->get('comment'));

        $em->persist($newComment);
        $em->flush();

        return new JsonResponse($newComment);
    }
}
