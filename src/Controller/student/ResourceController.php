<?php

namespace App\Controller\student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResourceController extends AbstractController
{
    /**
     * @Route("/resource", name="resource")
     */
    public function index(): Response
    {
        return $this->render('resource/index.html.twig', [
            'controller_name' => 'ResourceController',
        ]);
    }
}
