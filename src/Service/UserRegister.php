<?php

namespace App\Service;

use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\AuthenticatorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserRegister {
    private $em;
    private $passwordEncoder;
    private $emailVerifier;
    private $request;
    private $guardHandler;
    private $authenticator;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder,
        EmailVerifier $emailVerifier, Request $request, GuardAuthenticatorHandler $guardHandler, AuthenticatorInterface $authenticator) {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        $this->emailVerifier = $emailVerifier;
        $this->request = $request;
        $this->guardHandler = $guardHandler;
        $this->authenticator = $authenticator;
    }

    public function register(SecuredUserInterface $user, $plainPassword, $roles=[]): SecuredUserInterface {
        // encode the plain password
        $user
            ->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $plainPassword
                )
            )
            ->setRoles($roles);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function sendEmailConfirmation(SecuredUserInterface $user, $template) {
        // generate a signed url and email it to the user
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('ensgmm@gmail.com', 'ENSGMM team'))
                ->to($user->getEmail())
                ->subject('Please Confirm your Email')
                ->htmlTemplate($template)
        );
    }

    public function authenticate(SecuredUserInterface $user): Response {
        return $this->guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $this->request,
            $this->authenticator,
            'main' // firewall name in security.yaml
        );
    }

    public function registerAndSendEmailConfirmation(SecuredUserInterface $user, $plainPassword, $template, $roles=[]): SecuredUserInterface {
        $user = $this->register($user, $plainPassword, $roles);
        $this->sendEmailConfirmation($user, $template);

        return $user;
    }
}