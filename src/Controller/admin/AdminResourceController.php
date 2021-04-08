<?php

namespace App\Controller\admin;

use App\Entity\Resource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

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
     * @IsGranted("EDIT_RESOURCE", "resource")
     */
    public function edit(Resource $resource):Response {
        return new Response;
    }

    /**
     * delete a resource if granted required authorisation
     * 
     * @Route("/{id}", name="admin_resources_delete", methods={"DELETE"})
     * @IsGranted("DELETE_RESOURCE", "resource")
     */
    public function delete(Resource $resource):Response {
        return new Response;
    }
}
