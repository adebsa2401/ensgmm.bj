<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Form\AdminLoginFormType;
use App\Form\AdminRegistrationFormType;
use App\Repository\AdminRepository;
use App\Repository\AdminRequestRepository;
use App\Security\EmailVerifier;
use App\Service\ConfirmCriticAction;
use App\Service\UserRegister;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

#[Route("/admin")]
class AdminController extends AbstractController
{
    public const TEMPLATES_ROUTE_BASE = 'admin/security/';

    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route("/login", name: "admin_login", methods: ["GET", "POST"])]
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

    #[Route('/register', name: 'admin_admins_register', methods: ['GET', 'POST'])]
    public function registerAdmin(Request $request, AdminRequestRepository $adminRequestRepo, UserRegister $userRegister): Response
    {
        /**
         * if there's a admin-request-id parameter in request parameters
         * execute the controller only if it's the first admin to get registered
         */
        if(!$adminRequestId = $request->query->get('admin-request-id')) {
            $this->denyAccessUnlessGranted('IS_FIRST_ADMIN');
        }

        /**
         * if there's a admin-request-id parameter execute the controller
         * only if this id is valid
         */
        if($adminRequestId) {
            $adminRequest = $adminRequestRepo->findOneBy(['id' => $adminRequestId]);

            if(!$adminRequest || !$adminRequest->isApproved()) {
                throw new NotFoundHttpException('Invalid url link');
            }
        }

        $user = new Admin;

        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $userRegister->registerAndSendEmailConfirmation(
                $user,
                $form->get('plainPassword')->getData(),
                self::TEMPLATES_ROUTE_BASE.'confirmation_email.html.twig',
                $adminRequest ? [] : ['ROLE_SUPER_ADMIN']);

            return $userRegister->authenticate($user);
        }

        return $this->render(self::TEMPLATES_ROUTE_BASE.'register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'admin_verify_email')]
    public function verifyUserEmail(Request $request, AdminRepository $adminRepository): Response
    {
        $id = $request->get('id');

        if (null === $id) {
            return $this->redirectToRoute('admin_admins_register');
        }

        $user = $adminRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('admin_admins_register');
        }

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('admin_admins_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('admin_admins_register');
    }

    #[Route("/", name: "admin_admins_home", methods: ["GET"])]
    public function index(): Response {
        return new Response;
    }

    #[Route("/admins/{id}", name: "admin_admins_profile", methods: ["GET"])]
    #[Route("/admins/{id}", name: "admin_admins_delete", methods: ["DELETE"])]
    #[IsGranted('DELETE_ADMIN', 'admin')]
    #[Route("/admins/{id}", name: "admin_admins_edit", methods: ["PUT"])]
    #[IsGranted('EDIT_ADMIN', 'admin')]
    public function showProfile(Admin $admin, ConfirmCriticAction $confirm): Response {
        $form = $confirm->makeAction($admin);

        return $this->render(self::TEMPLATES_ROUTE_BASE.'show.html.twig', [
            'admin' => $admin,
            'confirm_form' => $form->createView()
        ]);
    }

    #[Route("/admins/{id}/send-mail", name: "admin_admins_sendMail", methods: ["POST"])]
    public function sendMail():Response {
        return new Response;
    }
}
