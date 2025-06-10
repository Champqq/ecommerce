<?php

declare(strict_types=1);

namespace App\Service\Checkout;

use App\Entity\Order;

interface CheckoutServiceInterface
{
    public function process(string $email): Order;
}
