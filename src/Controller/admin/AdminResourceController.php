<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/resources")
 */
class AdminResourceController extends AbstractController
{
    /**
     * @Route("/", name="admin_resources_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_resource/index.html.twig', [
            'controller_name' => 'AdminResourceController',
        ]);
    }

    /**
     * create a resource
     * 
     * @Route("/create", name="admin_resources_create", methods={"GET", "POST"})
     */
    public function create():Response {
        return new Response;
    }

    /**
     * show a resource
     * 
     * @Route("/{id}", name="admin_resources_show", methods={"GET"})
     */
    public function show():Response {
        return new Response;
    }

    /**
     * edit a resource
     * 
     * @Route("/{id}/edit", name="admin_resources_edit", methods={"GET", "PUT"})
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * delete a resource if granted required authorisation
     * 
     * @Route("/{id}", name="admin_resources_delete", methods={"DELETE"})
     */
    public function delete():Response {
        return new Response;
    }
}
