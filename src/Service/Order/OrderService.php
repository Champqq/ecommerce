<?php

declare(strict_types=1);

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderItem;

class OrderService implements OrderServiceInterface
{
    public function addItem(Order $order, OrderItem $item): void
    {
        if (!$order->getItems()->contains($item)) {
            $order->addItem($item);
        }
    }

    public function calculateTotal(Order $order): void
    {
        $total = 0.0;
        foreach ($order->getItems() as $item) {
            $total += $item->getTotal() ?? 0;
        }
        $order->setTotal($total);
    }

    public function decreaseStock(Order $order): void
    {
        foreach ($order->getItems() as $item) {
            $item->decreaseStock();
        }
    }

    public function applyStockAndTotal(Order $order): void
    {
        $this->calculateTotal($order);
        $this->decreaseStock($order);
    }
}
