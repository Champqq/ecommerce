<?php

declare(strict_types=1);

namespace App\Service\Cart\Modifier\OrderItem;

use App\Entity\OrderItem;

class QuantityModifier implements QuantityModifierInterface
{
    public function __invoke(OrderItem $item, int $quantity): void
    {
        $item->setQuantity($item->getQuantity() + $quantity);
        $item->setTotal($item->getQuantity() * $item->getUnitPrice());
    }
}
