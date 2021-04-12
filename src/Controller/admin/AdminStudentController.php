<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Service\ConfirmCriticAction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route("/admin/students")]
class AdminStudentController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/student/';

    /**
     * @Route("/", name="admin_students_home", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin_student/index.html.twig', [
            'controller_name' => 'AdminStudentController',
        ]);
    }

    #[Route("/{id}", name: "admin_students_show", methods: ["GET"])]
    #[Route("/{id}", name: "admin_students_edit", methods: ["PUT"])]
    #[IsGranted("ROLE_ADMIN")]
    #[Route("/{id}", name: "admin_students_delete", methods: ["DELETE"])]
    #[IsGranted("ROLE_ADMIN")]
    public function show(Student $student, ConfirmCriticAction $confirm):Response {
        $form = $confirm->makeAction($student);
        
        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', [
            'student' => $student,
            'confirm_form' => $form->createView()
        ]);
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
