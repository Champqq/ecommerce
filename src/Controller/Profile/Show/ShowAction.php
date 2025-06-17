<?php

declare(strict_types=1);

namespace App\Controller\Profile\Show;

use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowAction extends AbstractController
{
    #[Route('/order/{id}', name: 'order_show', methods: ['GET'])]
    public function __invoke(Order $order): Response
    {
        return $this->render(
            'order/show.html.twig',
            ['order' => $order]
        );
    }
}
