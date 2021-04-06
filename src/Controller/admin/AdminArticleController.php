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
}
