<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\View;

use App\Service\Cart\Context\CartContextInterface;
use Money\Currency;
use Money\Money;

class CartViewFactory implements CartViewFactoryInterface
{
    public function __construct(private CartContextInterface $cartContext)
    {
    }

    public function getData(): array
    {
        $cart = $this->cartContext->getCart();
        $items = [];
        $total = new Money(0, new Currency('USD'));

        foreach ($cart->getItems() as $item) {
            $price = $item->getUnitPriceMoney();
            $itemTotal = $price->multiply($item->getQuantity());

            $items[] = [
                'product' => $item->getProduct(),
                'quantity' => $item->getQuantity(),
                'size' => $item->getSize(),
                'total' => $itemTotal,
            ];
            $total = $total->add($itemTotal);
        }
        return ['items' => $items, 'total' => $total];
    }
}
