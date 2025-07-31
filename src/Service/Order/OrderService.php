<?php

declare(strict_types=1);

namespace App\Service\Order;

use App\Entity\Order;
use App\Entity\OrderItem;
use Money\Money;
use Money\Currency;

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
        $total = new Money(0, new Currency('USD'));

        foreach ($order->getItems() as $item) {
            $itemTotal = $item->getTotalMoney();
            $total = $total->add($itemTotal);
        }

        $order->setTotalMoney($total);
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
