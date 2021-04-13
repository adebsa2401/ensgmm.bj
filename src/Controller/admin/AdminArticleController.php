<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleCreationFormType;
use App\Repository\ArticleRepository;
use App\Service\ConfirmCriticAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route("/admin/articles")]
class AdminArticleController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/article/';

    #[Route("/", name: "admin_articles_home", methods: ["GET"])]
    public function index(ArticleRepository $repo): Response
    {
        return $this->render('admin_article/index.html.twig', [
            'controller_name' => 'AdminArticleController',
        ]);
    }

    #[Route("/create", name: "admin_articles_create", methods: ["GET", "POST"])]
    #[IsGranted("ROLE_WRITER")]
    public function create(Request $request, EntityManagerInterface $em): Response {
        $article = new Article;

        $form = $this->createForm(ArticleCreationFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedBy($this->getUser());
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_articles_home');
        }

        return $this->render(self::TEMPLATES_ROUTE_BASE.'create.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/{id}", name: "admin_articles_show", methods: ["GET"])]
    #[Route("/{id}", name: "admin_articles_edit", methods: ["PUT"])]
    #[IsGranted("ARTICLE_EDIT", "aricle")]
    #[Route("/{id}", name: "admin_articles_delete", methods: ["DELETE"])]
    #[IsGranted("ARTICLE_DELETE", "article")]
    public function show(Article $article, ConfirmCriticAction $confirm): Response {
        $form = $confirm->makeAction($article);

        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', [
            'article' => $article,
            'confirm_form' => $form
        ]);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}/comment", name: "admin_articles_comment", methods: ["POST"])]
    public function comment(Article $article, Request $request, EntityManagerInterface $em): Response {
        $comment = (new Comment)
            ->setArticle($article)
            ->setCreatedByAdmin($this->getUser())
            ->setContent($request->request->get('comment'));

        $em->persist($comment);
        $em->flush();

        return new JsonResponse($comment);
    }
}
