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

#[Route("/articles")]
class ArticleController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'student/article/';

    /**
     * @Route("/", name="app_articles_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route("/{id}",name: "app_articles_show", methods: ["GET"])]
    public function show(Article $article):Response {
        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', compact('article'));
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}/comment",name: "app_articles_comment", methods: ["POST"])]
    #[IsGranted("ARTICLE_COMMENT", "article")]
    public function comment(Article $article, EntityManagerInterface $em, Request $request):Response {
        $comment = (new Comment)
            ->setArticle($article)
            ->setCreatedByStudent($this->getUser())
            ->setContent($request->request->get('comment'));

        $em->persist($comment);
        $em->flush();

        return new JsonResponse($comment);
    }
}
