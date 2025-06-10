<?php

declare(strict_types=1);

namespace App\Service\Cart;

use App\Service\Cart\Context\CartContextInterface;
use App\Service\Cart\Factory\View\CartViewFactoryInterface;
use App\Service\Cart\Modifier\CartModifierInterface;
use App\Service\Entity\EntityServiceInterface;

class CartService implements CartServiceInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
        private CartContextInterface $cartContext,
        private CartViewFactoryInterface $cartViewFactory,
        private CartModifierInterface $cartModifier,
    ) {
    }

    public function add(int $productId, string $size, int $quantity): void
    {
        $cart = $this->cartContext->getCart();

        $this->cartModifier->addItem($cart, $productId, $size, $quantity);

        $this->entityService->save($cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->cartContext->getCart();

        $this->cartModifier->removeItem($cart, $productId);

        $this->entityService->save($cart);
    }

    public function clear(): void
    {
        $cart = $this->cartContext->getCart();

        $this->cartModifier->removeAllItems($cart);

        $this->entityService->save($cart);
    }

    public function getViewData(): array
    {
        return $this->cartViewFactory->getData();
    }

    public function updateQuantity(int $productId, int $quantity): void
    {
        $cart = $this->cartContext->getCart();

        $this->cartModifier->changeQuantity($cart, $productId, $quantity);

        $this->entityService->save($cart);
    }
}
