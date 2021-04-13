<?php

namespace App\Controller\Student;

use App\Entity\Student;
use App\Form\StudentLoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\StudentRegistrationFormType;
use App\Security\EmailVerifier;
use App\Repository\StudentRepository;
use App\Service\ConfirmCriticAction;
use App\Service\UserRegister;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

/**
 * @Route("/students")
 */
class StudentController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'student/security/';

    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier) {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/login", name="app_login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_students_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(self::TEMPLATES_ROUTE_BASE.'login.html.twig', [
            'form' => $this->createForm(StudentLoginFormType::class)->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/", name="app_students_home", methods={"GET"})
     */
    public function index(): Response {
        return new Response;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    #[IsGranted('IS_ANONYMOUS')]
    public function register(Request $request, UserRegister $userRegister): Response
    {
        $user = new Student();
        $form = $this->createForm(StudentRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRegister->registerAndSendEmailConfirmation(
                $user,
                $form->get('plainPassword')->getData(),
                self::TEMPLATES_ROUTE_BASE.'confirmation_email.html.twig');

            return $userRegister->authenticate($user);
        }

        return $this->render(self::TEMPLATES_ROUTE_BASE.'register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, StudentRepository $studentRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_students_register');
        }

        $user = $studentRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_students_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_students_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_students_register');
    }

    #[Route("/{id}/profile", name: "app_students_show_profile", methods: ["GET"])]
    #[Route("/{id}/profile", name: "app_students_edit_profile", methods: ["PUT"])]
    #[IsGranted("STUDENT_EDIT", "student")]
    #[Route("/{id}/profile", name: "app_students_delete", methods: ["DELETE"])]
    #[IsGranted("STUDENT_DELETE", "student")]
    public function show(Student $student, ConfirmCriticAction $confirm):Response {
        $form = $confirm->makeAction($student);

        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', [
            'student' => $student,
            'confirm_form' => $form
        ]);
    }
}
