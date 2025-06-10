<?php

declare(strict_types=1);

namespace App\Service\Cart\Modifier;

use App\Entity\Order;

interface CartModifierInterface
{
    public function addItem(Order $cart, int $productId, string $size, int $quantity): void;

    public function removeItem(Order $cart, int $productId): void;

    public function removeAllItems(Order $cart): void;

    public function changeQuantity(Order $cart, int $productId, int $quantity): void;
}
