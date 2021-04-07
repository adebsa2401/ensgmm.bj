<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminStudentController extends AbstractController
{
    /**
     * @Route("/admin/student", name="admin_student")
     */
    public function index(): Response
    {
        return $this->render('admin_student/index.html.twig', [
            'controller_name' => 'AdminStudentController',
        ]);
    }

    /**
     * edit a student account settings if granted required authorisation
     */
    public function edit():Response {
        return new Response;
    }

    /**
     * show a student profile
     */
    public function show():Response {
        return new Response;
    }

    /**
     * delete an student account if granted required authorisation
     */
    public function delete():Response {
        return new Response;
    }

    /**
     * grant student an admin role
     */
    public function setRole():Response {
        return new Response;
    }

    /**
     * send mail to the student
     */
    public function mail():Response {
        return new Response;
    }
}
