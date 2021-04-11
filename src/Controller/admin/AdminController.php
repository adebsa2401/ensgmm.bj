<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Form\AdminLoginFormType;
use App\Form\CheckPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/security/';

    /**
     * @Route("/login", name="admin_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin_admins_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(self::TEMPLATES_ROUTE_BASE.'login.html.twig', [
            'form' => $this->createForm(AdminLoginFormType::class)->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/", name="admin_admins_home", methods={"GET"})
     */
    public function index(): Response {
        return new Response;
    }

    /**
     * show an admin profile
     * 
     * @Route("/admins/{id}", name="admin_admins_show", methods={"GET"})
     */
    public function show(Admin $admin): Response {
        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', compact('admin'));
    }

    /**
     * delete an admin account if granted required authorisation
     * 
     * @Route("/admins/{id}", name="admin_admins_delete", methods={"DELETE"})
     * @IsGranted("DELETE_ADMIN", "admin")
     */
    public function delete(Admin $admin, EntityManagerInterface $em, Request $request):Response {
        $form = $this->createForm(CheckPasswordFormType::class);
        
        $form->handleRequest($request);
        $em->remove($admin);
        $em->flush();
        return new Response;
    }

    /**
     * edit an admin account settings if granted required authorisation
     * 
     * @Route("/admins/{id}/edit", name="admin_admins_edit", methods={"GET", "PUT"})
     * @IsGranted("EDIT_ADMIN", "admin")
     */
    public function edit(Admin $admin):Response {
        return new Response;
    }

    /**
     * send mail to an admin
     * 
     * @Route("/admins/{id}/send-mail", name="admin_admins_sendMail", methods={"POST"})
     */
    public function sendMail():Response {
        return new Response;
    }
}
