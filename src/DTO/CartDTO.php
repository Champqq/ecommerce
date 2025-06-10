<?php

declare(strict_types=1);

namespace App\DTO;

class CartDTO
{
    private int $quantity;
    private string $size;

    public function __construct(int $quantity, string $size)
    {
        $this->quantity = $quantity;
        $this->size = $size;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getSize(): string
    {
        return $this->size;
    }
}
