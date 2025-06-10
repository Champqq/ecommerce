<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\DTO\ProfileUpdateDTO;
use App\Service\Entity\EntityServiceInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileService implements ProfileServiceInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function update(UserInterface $user, ProfileUpdateDTO $profileDTO): void
    {
        if ($profileDTO->getPassword()) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $profileDTO->getPassword());
            $user->setPassword($hashedPassword);
        }

        if ($profileDTO->getPhone()) {
            $user->setPhone($profileDTO->getPhone());
        }

        $this->entityService->save($user);
    }
}
