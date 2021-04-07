<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/login", name="admin_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="admin_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * show an admin profile
     * 
     * @Route("/admins/{id}", name="admin_admins_show", methods={"GET"})
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * delete an admin account if granted required authorisation
     * 
     * @Route("/admins/{id}", name="admin_admins_delete", methods={"DELETE"})
     */
    public function delete():Response {
        return new Response;
    }

    /**
     * edit an admin account settings if granted required authorisation
     * 
     * @Route("/admins/{id}/edit", name="admin_admins_edit", methods={"GET", "PUT"})
     */
    public function edit():Response {
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
