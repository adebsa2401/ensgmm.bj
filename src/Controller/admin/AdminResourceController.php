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

    /**
     * create a resource
     */
    public function create():Response {
        return new Response;
    }

    /**
     * show a resource
     */
    public function show():Response {
        return new Response;
    }

    /**
     * edit a resource
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * delete a resource if granted required authorisation
     */
    public function delete():Response {
        return new Response;
    }
}
