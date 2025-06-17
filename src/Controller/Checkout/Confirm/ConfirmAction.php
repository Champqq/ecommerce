<?php

declare(strict_types=1);

namespace App\Controller\Checkout\Confirm;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmAction extends AbstractController
{
    #[Route('/checkout/confirmation/{id}', name: 'checkout_confirmation', methods: ['GET'])]
    public function confirmation(Order $order): Response
    {
        return $this->render(
            'checkout/confirmation.html.twig', [
                'order' => $order
            ]
        );
    }
}
