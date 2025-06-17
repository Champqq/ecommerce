<?php

declare(strict_types=1);

namespace App\Controller\Checkout\Show;

use App\Service\Cart\Context\CartContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ShowAction extends AbstractController
{
    public function __construct(
        private CartContextInterface $cartContext
    ) {
    }

    #[Route('/checkout', name: 'checkout_show', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render(
            'checkout/index.html.twig', [
                'order' => $this->cartContext->getCart()
            ]
        );
    }
}
