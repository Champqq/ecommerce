<?php

declare(strict_types=1);

namespace App\Service\Checkout\Modifier;

use App\Entity\Order;
use App\Service\Entity\EntityServiceInterface;
use App\Service\Order\OrderServiceInterface;

class OrderModifier implements OrderModifierInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
        private OrderServiceInterface $orderService
    ) {
    }

    public function modify(Order $order, string $email): void
    {
        $order->setStatus('new');
        $order->setCustomerEmail($email);
        $this->orderService->applyStockAndTotal($order);

        $this->entityService->save($order);
    }
}
