<?php

declare(strict_types=1);

namespace App\Service\Cart\Context;

use App\Entity\Order;
use App\Service\Cart\Factory\Guest\GuestCartFactoryInterface;
use App\Service\Cart\Factory\User\UserCartFactoryInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class CartContext implements CartContextInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private Security $security,
        private GuestCartFactoryInterface $guestCartFactory,
        private UserCartFactoryInterface $userCartFactory,
    ) {
    }

    public function getCart(): Order
    {
        $user = $this->security->getUser();
        $session = $this->requestStack->getSession();

        if ($user) {
            return $this->userCartFactory->getUserCart($user);
        }

        return $this->guestCartFactory->getGuestCart($session);
    }

    public function getItemsCount(): int
    {
        $cart = $this->getCart();

        return array_sum(
            array_map(
                fn($item) => $item->getQuantity(),
                $cart->getItems()->toArray(),
            )
        );
    }
}
