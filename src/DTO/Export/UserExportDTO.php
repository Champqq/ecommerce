<?php

declare(strict_types = 1);

namespace App\DTO\Export;

use App\Entity\User;

final readonly class UserExportDTO
{
    public function __construct(
        public int $id,
        public string $email,
        public ?string $phone,
        public array $roles,
        public ?int $githubId,
        public ?string $googleId,
        public int $ordersCount = 0,
    ) {
    }

    public static function fromEntity(User $user): self
    {
        $roles = [];
        foreach ($user->getRoles() as $role) {
            $roles[] = [
                'role' => $role,
            ];
        }

        return new self(
            id: $user->getId(),
            email: $user->getEmail(),
            phone: $user->getPhone(),
            roles: $roles,
            githubId: $user->getGithubId(),
            googleId: $user->getGoogleId(),
            ordersCount: $user->getOrders()->count()
        );
    }
}
