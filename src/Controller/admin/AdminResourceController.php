<?php

namespace App\Controller\Admin;

use App\Entity\Resource;
use App\Form\ResourceCreationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route("/admin/resources")]
class AdminResourceController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/resource/';

    /**
     * @Route("/", name="admin_resources_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_resource/index.html.twig', [
            'controller_name' => 'AdminResourceController',
        ]);
    }

    #[Route("/create", name: "admin_resources_create", methods: ["GET", "POST"])]
    public function create(Request $request, EntityManagerInterface $em):Response {
        $resource = new Resource;

        $form = $this->createForm(ResourceCreationFormType::class, $resource);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($resource);
            $em->flush();
        }

        return $this->render(self::TEMPLATES_ROUTE_BASE.'create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}", name: "admin_resources_show", methods: ["GET"])]
    public function show(Resource $resource):Response {
        return new JsonResponse($resource);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}", name: "admin_resources_edit", methods: ["PUT"])]
    public function edit(Resource $resource, Request $request, EntityManagerInterface $em) {
        // set the new resource

        $em->persist($resource);
        $em->flush();

        return new JsonResponse($resource);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}", name: "admin_resources_delete", methods: ["DELETE"])]
    #[IsGranted("RESOURCE_DELETE", "resource")]
    public function delete(Resource $resource, EntityManagerInterface $em) {
        $em->remove($resource);
        $em->flush();

        return new JsonResponse($resource);
    }
}
