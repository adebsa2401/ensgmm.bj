<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
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
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * show an admin profile
     */
    public function show(): Response {
        return new Response;
    }

    /**
     * delete an admin account if granted required authorisation
     */
    public function delete():Response {
        return new Response;
    }

    /**
     * edit an admin account settings if granted required authorisation
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * set an admin role
     */
    public function setRole():Response {
        return new Response;
    }

    /**
     * send mail to an admin
     */
    public function mail():Response {
        return new Response;
    }
}
