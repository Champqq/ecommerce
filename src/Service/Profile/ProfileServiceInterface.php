<?php

declare(strict_types=1);

namespace App\Service\Profile;

use App\DTO\ProfileUpdateDTO;
use Symfony\Component\Security\Core\User\UserInterface;

interface ProfileServiceInterface
{
    public function update(UserInterface $user, ProfileUpdateDTO $profileDTO): void;
}
