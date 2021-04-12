<?php

namespace App\Service;

use App\Form\CheckPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class ConfirmCriticAction {
    private $formBuilder;
    private $em;
    private $request;

    public function __construct(FormFactoryInterface $formBuilder, EntityManagerInterface $em, Request $request) {
        $this->formBuilder = $formBuilder;
        $this->em = $em;
        $this->request = $request;
    }

    public function generatePasswordConfirmationForm() {
        $form = $this->formBuilder->create(CheckPasswordFormType::class);
        $form->handleRequest($this->request);

        return $form;
    }

    public function isConfirmed(FormInterface $form) {
        return $form->isSubmitted() &&
            $form->isValid();
    }

    public function makeAction($entity) {
        $form = $this->generatePasswordConfirmationForm();

        if($this->isConfirmed($form)) {
            if($this->request->getMethod() == "DELETE") {
                $this->em->remove($entity);
            } elseif($this->request->getMethod() == "PUT") {
                $this->em->persist($entity);
            } else {
                return;
            }

            $this->em->flush();
        }

        return $form;
    }
}
