<?php

declare(strict_types = 1);

namespace App\DTO\Export;

use App\Entity\Order;

final readonly class OrderExportDTO
{
    public function __construct(
        public int $id,
        public string $number,
        public ?string $status,
        public string $total,
        public ?array $items,
        public ?string $customerEmail,
    ) {
    }

    public static function fromEntity(Order $order): self
    {
        $items = [];
        foreach ($order->getItems() as $item) {
            $items[] = [
                'productName' => $item->getProduct()?->getName(),
                'quantity' => $item->getQuantity(),
                'total' => $item->getTotal()->getAmount(),
            ];
        }

        return new self(
            id: $order->getId(),
            number: $order->getNumber(),
            status: $order->getStatus(),
            total: $order->getTotal()->getAmount(),
            items: $items,
            customerEmail: $order->getCustomerEmail(),
        );
    }
}
