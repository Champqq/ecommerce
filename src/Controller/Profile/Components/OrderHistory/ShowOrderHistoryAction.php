<?php

declare(strict_types=1);

namespace App\Controller\Profile\Components\OrderHistory;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowOrderHistoryAction extends AbstractController
{
    #[Route('/profile/orders', name: 'order_history', methods: ['GET'])]
    public function __invoke(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'profile/order-history.html.twig', [
                'orders' => $user->getOrders()
            ]
        );
    }
}
