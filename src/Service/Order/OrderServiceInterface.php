<?php

declare(strict_types = 1);

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderItem;

interface OrderServiceInterface
{
    public function addItem(Order $order, OrderItem $item): void;

    public function calculateTotal(Order $order): void;
}
