<?php

declare(strict_types=1);

namespace App\Controller\Cart\Clear;

use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ClearAction extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {
    }

    #[Route('/cart/clear', name: 'cart_clear', methods: ['POST'])]
    public function __invoke(): Response
    {
        $this->cartService->clear();

        return $this->redirectToRoute('cart');
    }
}


