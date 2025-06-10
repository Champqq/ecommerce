<?php

declare(strict_types=1);

namespace App\Service\Cart\Factory\Guest;

use App\Entity\Order;
use App\Repository\OrderRepository;
use App\Service\Entity\EntityServiceInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GuestCartFactory implements GuestCartFactoryInterface
{
    public function __construct(
        private OrderRepository $orderRepository,
        private EntityServiceInterface $entityService,
        private string $cartSessionKey,
    ) {
    }

    public function getGuestCart(SessionInterface $session): Order
    {
        $cartId = $session->get($this->cartSessionKey);

        if ($cartId) {
            $cart = $this->orderRepository->findOneBy(['id' => $cartId, 'status' => 'cart']);
            if ($cart !== null) {
                return $cart;
            }
        }

        return $this->createGuestCart($session);
    }

    private function createGuestCart(SessionInterface $session): Order
    {
        $cart = new Order();
        $cart->setStatus('cart');

        $this->entityService->save($cart);
        $session->set($this->cartSessionKey, $cart->getId());

        return $cart;
    }
}
