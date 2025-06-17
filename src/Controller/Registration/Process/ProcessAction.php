<?php

declare(strict_types=1);

namespace App\Controller\Registration\Process;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Service\Registration\RegistrationServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProcessAction extends AbstractController
{
    public function __construct(
        private RegistrationServiceInterface $registrationService
    ) {
    }

    #[Route('/register', name: 'register_process', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->registrationService->register($user, $form);

            return $this->redirectToRoute('login_show');
        }

        return $this->render(
            'registration/register.html.twig', [
                'registrationForm' => $form
            ]
        );
    }
}
