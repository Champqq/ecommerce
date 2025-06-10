<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\View;

use App\Service\Cart\Context\CartContextInterface;

class CartViewFactory implements CartViewFactoryInterface
{
    public function __construct(private CartContextInterface $cartContext)
    {
    }

    public function getData(): array
    {
        $cart = $this->cartContext->getCart();
        $items = [];
        $total = 0;

        foreach ($cart->getItems() as $item) {
            $items[] = [
                'product' => $item->getProduct(),
                'quantity' => $item->getQuantity(),
                'size' => $item->getSize(),
                'total' => $item->getQuantity() * $item->getUnitPrice(),
            ];
            $total += $item->getQuantity() * $item->getUnitPrice();
        }

        return ['items' => $items, 'total' => $total];
    }
}
