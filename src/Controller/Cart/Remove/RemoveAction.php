<?php

declare(strict_types=1);

namespace App\Controller\Cart\Remove;

use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RemoveAction extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function __invoke(int $id): Response
    {
        $this->cartService->remove($id);

        return $this->redirectToRoute('cart');
    }
}
