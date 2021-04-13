<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/change-password-requests')]
class AdminChangePasswordRequestController extends AbstractController
{
    #[Route('/', name: 'admin_change_password_request')]
    public function index(): Response
    {
        return $this->render('admin_change_password_request/index.html.twig', [
            'controller_name' => 'AdminChangePasswordRequestController',
        ]);
    }

    #[Route('/{id}', name: 'admin_change_password_request_approve', methods: ['POST'])]
    public function approve(): Response {
        return new Response;
    }

    #[Route('/{id}', name: 'admin_change_password_request_delete', methods: ['DELETE'])]
    public function delete(): Response {
        return new Response;
    }
}
