<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\User;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\Entity\EntityServiceInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserCartFactory implements UserCartFactoryInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private EntityServiceInterface $entityService,
    ) {
    }

    public function getUserCart(UserInterface $user): Order
    {
        $cart = $this->orderRepository->findOneBy(['user' => $user, 'status' => 'cart']);

        if (!$cart) {
            return $this->createUserCart($user);
        }

        return $cart;
    }

    private function createUserCart(UserInterface $user): Order
    {
        $cart = new Order();
        $cart->setStatus('cart');
        $cart->setUser($user);

        $this->entityService->save($cart);

        return $cart;
    }
}
