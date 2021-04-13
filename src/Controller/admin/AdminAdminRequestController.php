<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/admin-requests')]
class AdminAdminRequestController extends AbstractController
{
    #[Route('/', name: 'admin_admin_requests')]
    public function index(): Response
    {
        return $this->render('admin_admin_request/index.html.twig', [
            'controller_name' => 'AdminAdminRequestController',
        ]);
    }

    #[Route('/{id}', name: 'admin_admin_requests_approve', methods: ['POST'])]
    public function approve(): Response {
        return new Response;
    }

    #[Route('/{id}', name: 'admin_admin_requests_delete', methods: ['DELETE'])]
    public function delete(): Response {
        return new Response;
    }
}
