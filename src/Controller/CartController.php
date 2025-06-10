<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Cart\CartServiceInterface;
use App\Service\Cart\Request\CartDataHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService,
        private CartDataHandlerInterface $cartDataHandler
    ) {
    }

    #[Route('/cart', name: 'cart')]
    public function index(): Response
    {
        return $this->render(
            'cart/index.html.twig',
            $this->cartService->getViewData()
        );
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function add(int $id, Request $request): Response
    {
        $dto = $this->cartDataHandler->getAddToCartData($request);

        $this->cartService->add($id, $dto->getSize(), $dto->getQuantity());

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function remove(int $productId): Response
    {
        $this->cartService->remove($productId);

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/clear', name: 'cart_clear', methods: ['POST'])]
    public function clear(): Response
    {
        $this->cartService->clear();

        return $this->redirectToRoute('cart');
    }

    #[Route('/cart/update/{productId}', name: 'cart_update_quantity', methods: ['POST'])]
    public function updateQuantity(int $productId, Request $request): void
    {
        $quantity = $this->cartDataHandler->getQuantityFromCartData($request);

        $this->cartService->updateQuantity($productId, $quantity);
    }
}
