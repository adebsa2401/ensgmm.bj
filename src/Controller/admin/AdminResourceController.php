<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminResourceController extends AbstractController
{
    /**
     * @Route("/admin/resource", name="admin_resource")
     */
    public function index(): Response
    {
        return $this->render('admin_resource/index.html.twig', [
            'controller_name' => 'AdminResourceController',
        ]);
    }
}
