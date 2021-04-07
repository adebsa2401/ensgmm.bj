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

    /**
     * Create a resource
     */
    public function create():Response {
        return new Response;
    }

    /**
     * Edit a resource (editing request should be sent first)
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * show a resource
     */
    public function show():Response {
        return new Response;
    }

    /**
     * download a resource
     */
    public function download():Response {
        return new Response;
    }
}
