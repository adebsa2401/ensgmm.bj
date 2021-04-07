<?php

namespace App\Controller\student;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/resources")
 */
class ResourceController extends AbstractController
{
    /**
     * @Route("/", name="app_resources_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('resource/index.html.twig', [
            'controller_name' => 'ResourceController',
        ]);
    }

    /**
     * Create a resource
     * 
     * @Route("/create", name="app_resources_create", methods={"GET", "POST"})
     */
    public function create():Response {
        return new Response;
    }

    /**
     * Edit a resource (editing request should be sent first)
     * 
     * @Route("/{id}/edit", name="app_resources_edit", methods={"GET", "PUT"})
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * show a resource
     * 
     * @Route("/{id}", name="app_resources_show", methods={"GET"})
     */
    public function show():Response {
        return new Response;
    }

    /**
     * download a resource
     * 
     * @Route("/{id}/download", name="app_resources_download", methods={"GET"})
     */
    public function download():Response {
        return new Response;
    }
}
