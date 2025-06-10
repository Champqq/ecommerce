<?php

declare(strict_types=1);

namespace App\Service\Checkout;

use App\Entity\Order;
use App\Service\Cart\CartServiceInterface;
use App\Service\Cart\Context\CartContextInterface;
use App\Service\Checkout\Modifier\OrderModifierInterface;

class CheckoutService implements CheckoutServiceInterface
{
    public function __construct(
        private CartServiceInterface $cartService,
        private OrderModifierInterface $orderModifier,
        private CartContextInterface $cartContext,
    ) {
    }

    public function process(string $email): Order
    {
        $order = $this->cartContext->getCart();

        $this->orderModifier->modify($order, $email);

        $this->cartService->clear();

        return $order;
    }
}
