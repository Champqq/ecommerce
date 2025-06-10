<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Order;
use App\Service\Cart\Context\CartContextInterface;
use App\Service\Checkout\CheckoutServiceInterface;
use App\Service\Checkout\Request\EmailHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CheckoutController extends AbstractController
{
    public function __construct(
        private CartContextInterface $cartContext,
        private CheckoutServiceInterface $checkoutService,
        private EmailHandlerInterface $emailHandler,
    ) {
    }

    #[Route('/checkout', name: 'checkout')]
    public function checkout(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $email = $this->emailHandler->handleEmail($request);

            $order = $this->checkoutService->process($email);

            return $this->redirectToRoute(
                'checkout_confirmation',
                ['id' => $order->getId()]
            );
        }

        return $this->render(
            'checkout/index.html.twig',
            ['order' => $this->cartContext->getCart()]
        );
    }

    #[Route('/checkout/confirmation/{id}', name: 'checkout_confirmation', methods: ['GET'])]
    public function confirmation(Order $order): Response
    {
        return $this->render(
            'checkout/confirmation.html.twig',
            ['order' => $order]
        );
    }
}
