<?php

declare(strict_types=1);

namespace App\Controller\Checkout\Process;

use App\Service\Checkout\CheckoutServiceInterface;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProcessAction extends AbstractController
{
    public function __construct(
        private CheckoutServiceInterface $checkoutService
    ) {
    }

    #[Route('/checkout', name: 'checkout_process', methods: ['POST'])]
    public function __invoke(Request $request, Security $security): Response
    {
        if ($security->getUser()) {
            $email = $security->getUser()->getEmail();
        } else {
            $email = $request->request->get('email');
        }

        try {
            $order = $this->checkoutService->process($email);
        } catch (LogicException $e) {
            $this->addFlash('danger', $e->getMessage());
            return $this->redirectToRoute('cart');
        }

        return $this->redirectToRoute(
            'checkout_confirmation', [
                'id' => $order->getId()
            ]
        );
    }
}
