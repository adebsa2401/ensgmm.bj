<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/admin/students")
 */
class AdminStudentController extends AbstractController
{
    /**
     * @Route("/", name="admin_students_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_student/index.html.twig', [
            'controller_name' => 'AdminStudentController',
        ]);
    }

    /**
     * edit a student account settings if granted required authorisation
     * 
     * @Route("/{id}/edit", name="admin_students_edit", methods={"GET", "PUT"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * show a student profile
     * 
     * @Route("/{id}", name="admin_students_show", methods={"GET"})
     */
    public function show():Response {
        return new Response;
    }

    /**
     * delete an student account if granted required authorisation
     * 
     * @Route("/{id}", name="admin_students_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete():Response {
        return new Response;
    }

    /**
     * send mail to the student
     * 
     * @Route("/{id}/send-mail", name="admin_students_sendMail", methods={"POST"})
     */
    public function sendMail():Response {
        return new Response;
    }
}
