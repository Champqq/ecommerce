<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\Cart\Context\CartContextInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CartExtension extends AbstractExtension
{
    public function __construct(private CartContextInterface $cartContext)
    {
    }

    public function getFunctions(): array
    {
        return [new TwigFunction('cart_items_count', [$this, 'getCartItemsCount'])];
    }

    public function getCartItemsCount(): int
    {
        return $this->cartContext->getItemsCount();
    }
}
