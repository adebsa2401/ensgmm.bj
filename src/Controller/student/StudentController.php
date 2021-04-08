<?php

namespace App\Controller\student;

use App\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/students")
 */
class StudentController extends AbstractController
{
    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
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
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * register a new student
     * 
     * @Route("/register", name="app_students_register", methods={"GET", "POST"})
     * @IsGranted("IS_ANONYMOUS")
     */
    public function register():Response {
        return new Response;
    }

    /**
     * edit student user account
     * 
     * @Route("/{id}/profile/edit", name="app_students_edit_profile", methods={"GET", "PUT"})
     * @IS_GRANTED("STUDENT_EDIT", "student")
     */
    public function edit(Student $student):Response {
        return new Response;
    }

    /**
     * show student profile
     * 
     * @Route("/{id}/profile", name="app_students_show_profile", methods={"GET"})
     */
    public function show():Response {
        return new Response;
    }

    /**
     * delete student user account if granted required authorisation
     * 
     * @Route("/{id}/delete", name="app_students_delete", methods={"DELETE"})
     * @IsGranted("STUDENT_DELETE", "student")
     */
    public function delete(Student $student):Response {
        return new Response;
    }
}
