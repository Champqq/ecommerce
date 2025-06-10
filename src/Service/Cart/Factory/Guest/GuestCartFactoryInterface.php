<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\Guest;

use App\Entity\Order;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface GuestCartFactoryInterface
{
    public function getGuestCart(SessionInterface $session): Order;
}
