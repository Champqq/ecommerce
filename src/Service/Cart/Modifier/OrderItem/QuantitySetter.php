<?php

declare(strict_types=1);

namespace App\Service\Cart\Modifier\OrderItem;

use App\Entity\OrderItem;

class QuantitySetter implements QuantitySetterInterface
{
    public function __invoke(OrderItem $item, int $quantity): void
    {
        $item->setQuantity($quantity);
        $item->setTotal($quantity * $item->getUnitPrice());
    }
}
