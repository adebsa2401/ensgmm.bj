<?php

namespace App\Controller;

use App\Entity\AdminRequest;
use App\Form\AdminRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin-request')]
class AdminRequestController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin_request/';

    #[Route('/create', name: 'app_admin_request_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response {
        $adminRequest = new AdminRequest;

        $form = $this->createForm(AdminRegistrationFormType::class, $adminRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($adminRequest);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render(self::TEMPLATES_ROUTE_BASE.'create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
