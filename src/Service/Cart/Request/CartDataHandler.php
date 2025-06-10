<?php

declare(strict_types = 1);

namespace App\Service\Cart\Request;

use App\DTO\CartDTO;
use Symfony\Component\HttpFoundation\Request;

class CartDataHandler implements CartDataHandlerInterface
{
    public function getAddToCartData(Request $request): CartDTO
    {
        $size = $request->get('size');
        $quantity = (int) $request->get('quantity');
        return new CartDto($quantity, $size);
    }

    public function getQuantityFromCartData(Request $request): int
    {
        return (int) $request->get('quantity');
    }
}
