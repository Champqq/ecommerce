<?php

declare(strict_types=1);

namespace App\Service\Cart;

interface CartServiceInterface
{
    public function add(int $productId, string $size, int $quantity);
    public function remove(int $productId);
    public function clear();
    public function updateQuantity(int $productId, int $quantity);
}
