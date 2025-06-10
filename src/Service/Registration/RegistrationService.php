<?php

declare(strict_types=1);

namespace App\Service\Registration;

use App\Service\Entity\EntityServiceInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationService implements RegistrationServiceInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function register(UserInterface $user, FormInterface $form): void
    {
        $password = $form->get('plainPassword')->getData();

        $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        $user->setEmail(strtolower($user->getEmail()));

        $this->entityService->save($user);
    }
}
