<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/change-password-requests')]
class ChangePasswordRequestController extends AbstractController
{
    #[Route('/', name: 'app_change_password_request')]
    public function index(): Response
    {
        return $this->render('change_password_request/index.html.twig', [
            'controller_name' => 'ChangePasswordRequestController',
        ]);
    }

    #[Route('/send-request', name: 'app_change_password_request_send', methods: ['POST'])]
    public function sendRequest(): Response {
        return new Response;
    }

    #[Route('/change-password', name: 'app_change_password_request_change', methods: ['GET', 'POST'])]
    public function changePassword(): Response {
        return new Response;
    }
}
