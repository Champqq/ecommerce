<?php

declare(strict_types=1);

namespace App\DTO;

class ProfileUpdateDTO
{
    private ?string $phone = null;
    private ?string $password = null;

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}

