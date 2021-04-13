<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use App\Entity\AdminRequest;
use App\Form\AdminLoginFormType;
use App\Form\AdminRegistrationFormType;
use App\Repository\AdminRepository;
use App\Security\AdminAuthenticator;
use App\Security\EmailVerifier;
use App\Service\ConfirmCriticAction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
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

    /**
     * @IsGranted("IS_FIRST_ADMIN")
     */
    #[Route('/register', name: 'admin_register', methods: ['GET', 'POST'])]
    public function registerFirstAdmin(Request $request, UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $guardHandler, AdminAuthenticator $authenticator,
        EntityManagerInterface $em): Response
    {
        $user = new Admin;

        $form = $this->createForm(AdminRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_SUPER_ADMIN']);

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

    #[Route('/register/{request_id}', name: 'admin_register', methods: ['GET', 'POST'])]
    public function registerAdmin(AdminRequest $adminRequest, Request $request,
        UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em,
        GuardAuthenticatorHandler $guardHandler, AdminAuthenticator $authenticator): Response {
        if(!$adminRequest->isApproved()) {
            throw new NotFoundHttpException;
        }

        $user = new Admin;

        $form = $this->createForm(AdminRegistrationFormType::class, $user);
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
