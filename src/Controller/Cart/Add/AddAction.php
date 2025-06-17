<?php

declare(strict_types=1);

namespace App\Controller\Cart\Add;

use App\DTO\CartDTO;
use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddAction extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function __invoke(int $id, Request $request): Response
    {
        $size = $request->get('size');
        $quantity = (int) $request->get('quantity');

        $dto = new CartDto($quantity, $size);

        $this->cartService->add($id, $dto->getSize(), $dto->getQuantity());

        return $this->redirectToRoute('cart');
    }
}
