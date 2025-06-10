<?php

declare(strict_types=1);

namespace App\Service\Checkout\Modifier;

use App\Entity\Order;

interface OrderModifierInterface
{
    public function modify(Order $order, string $email): void;
}
