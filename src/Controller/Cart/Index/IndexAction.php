<?php

declare(strict_types=1);

namespace App\Controller\Cart\Index;

use App\Service\Cart\CartServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexAction extends AbstractController
{
    public function __construct(
        private CartServiceInterface $cartService
    ) {
    }

    #[Route('/cart', name: 'cart', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render(
            'cart/index.html.twig',
            $this->cartService->getViewData()
        );
    }
}
