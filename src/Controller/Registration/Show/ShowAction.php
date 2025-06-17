<?php

declare(strict_types=1);

namespace App\Controller\Registration\Show;

use App\Entity\User;
use App\Form\RegistrationForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowAction extends AbstractController
{
    #[Route('/register', name: 'register_show', methods: ['GET'])]
    public function __invoke(): Response
    {
        $form = $this->createForm(RegistrationForm::class, new User());

        return $this->render(
            'registration/register.html.twig', [
                'registrationForm' => $form
            ]
        );
    }
}
