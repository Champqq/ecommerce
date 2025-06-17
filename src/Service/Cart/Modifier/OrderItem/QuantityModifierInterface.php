<?php

declare(strict_types=1);

namespace App\Service\Cart\Modifier\OrderItem;

use App\Entity\OrderItem;

interface QuantityModifierInterface
{
    public function __invoke(OrderItem $item, int $quantity): void;
}
