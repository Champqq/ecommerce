<?php

declare(strict_types=1);

namespace App\Service\Cart\Request;

use App\DTO\CartDTO;
use Symfony\Component\HttpFoundation\Request;

interface CartDataHandlerInterface
{
    public function getAddToCartData(Request $request): CartDTO;

    public function getQuantityFromCartData(Request $request): int;
}
