<?php

declare(strict_types=1);

namespace App\Service\Cart\Modifier;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Service\Entity\EntityServiceInterface;
use App\Service\Order\OrderServiceInterface;

class CartModifier implements CartModifierInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private ProductRepository $productRepository,
        private EntityServiceInterface $entityService,
        private OrderServiceInterface $orderService,
    ) {
    }

    public function addItem(Order $cart, int $productId, string $size, int $quantity): void
    {
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getId() === $productId) {
                $item->setSize($size);
                $item->setQuantity($item->getQuantity() + $quantity);
                $item->setTotal($item->getQuantity() * $item->getUnitPrice());

                $this->entityService->save($item);

                return;
            }
        }

        $product = $this->productRepository->findProduct($productId);
        $orderItem = $this->orderRepository->createOrderItem($product, $quantity, $size);

        $this->orderService->addItem($cart, $orderItem);

        $this->entityService->save($orderItem);
    }

    public function removeItem(Order $cart, int $productId): void
    {
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getId() === $productId) {
                $cart->getItems()->removeElement($item);
                $this->entityService->markToDelete($item);
            }
        }
    }

    public function removeAllItems(Order $cart): void
    {
        foreach ($cart->getItems() as $item) {
            $this->entityService->markToDelete($item);
        }

        $cart->getItems()->clear();
    }

    public function changeQuantity(Order $cart, int $productId, int $quantity): void
    {
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getId() === $productId) {
                $item->setQuantity($quantity);
                $item->setTotal($item->getUnitPrice() * $quantity);
            }
        }
    }
}
