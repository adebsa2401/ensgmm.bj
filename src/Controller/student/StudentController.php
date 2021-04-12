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
use App\Security\StudentAuthenticator;
use App\Repository\StudentRepository;
use App\Service\ConfirmCriticAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
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
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/", name="app_students_home", methods={"GET"})
     */
    public function index(): Response {
        return new Response;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    #[IsGranted('IS_ANONYMOUS')]
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, StudentAuthenticator $authenticator, EntityManagerInterface $em): Response
    {
        $user = new Student();
        $form = $this->createForm(StudentRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $em->persist($user);
            $em->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('ensgmm@gmail.com', 'ENSGMM team'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate(self::TEMPLATES_ROUTE_BASE.'confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
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
