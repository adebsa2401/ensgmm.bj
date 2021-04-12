<?php

namespace App\Controller\Student;

use App\Entity\Resource;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route("/resources")]
class ResourceController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'student/resource/';

    /**
     * @Route("/", name="app_resources_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('resource/index.html.twig', [
            'controller_name' => 'ResourceController',
        ]);
    }

    #[Route("/create", name: "app_resources_create", methods: ["GET", "POST"])]
    #[IsGranted("ROLE_USER")]
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
    #[Route("/{id}/edit", name: "app_resources_edit", methods: ["PUT"])]
    #[IsGranted("ROLE_USER")]
    public function edit(Resource $resource, Request $request, EntityManagerInterface $em):Response {
        // set new resource

        $em->persist($resource);
        $em->flush();

        return new JsonResponse($resource);
    }

    /**
     * @return JsonResponse
     */
    #[Route("/{id}", name: "app_resources_show", methods: ["GET"])]
    public function show(Resource $resource):Response {
        return new JsonResponse($resource);
    }

    #[Route("/{id}/download", name: "app_resources_download", methods: ["GET"])]
    public function download(Resource $resource):Response {
        return $this->render($resource->getUrl());
    }
}
