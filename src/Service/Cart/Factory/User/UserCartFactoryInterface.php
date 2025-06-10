<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\User;

use App\Entity\Order;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserCartFactoryInterface
{
    public function getUserCart(UserInterface $user): Order;
}
