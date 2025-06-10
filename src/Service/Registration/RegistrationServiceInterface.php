<?php

declare(strict_types=1);

namespace App\Service\Registration;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface RegistrationServiceInterface
{
    public function register(UserInterface $user, FormInterface $form): void;
}
