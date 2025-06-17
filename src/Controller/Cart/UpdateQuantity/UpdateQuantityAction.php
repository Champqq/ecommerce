<?php

declare(strict_types=1);

namespace App\Controller\Cart\UpdateQuantity;

use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class UpdateQuantityAction extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {
    }

    #[Route('/cart/update/{productId}', name: 'cart_update_quantity', methods: ['POST'])]
    public function __invoke(int $productId, Request $request): void
    {
        $quantity = (int) $request->get('quantity');

        $this->cartService->updateQuantity($productId, $quantity);
    }
}

