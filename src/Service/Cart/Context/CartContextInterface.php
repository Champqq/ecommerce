<?php

declare(strict_types=1);

namespace App\Service\Cart\Context;

use App\Entity\Order;

interface CartContextInterface
{
    public function getCart(): Order;

    public function getItemsCount(): int;
}
