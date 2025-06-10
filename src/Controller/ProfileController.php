<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Order;
use App\Service\Profile\ProfileServiceInterface;
use App\Service\Profile\Request\ProfileRequestHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public function __construct(
        private ProfileServiceInterface $profileService,
        private ProfileRequestHandlerInterface $profileRequestHandler,
    ) {
    }

    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig');
    }

    #[Route('/profile/update', name: 'profile_update', methods: ['POST'])]
    public function update(Request $request): Response
    {
        $user = $this->getUser();

        $profileDTO = $this->profileRequestHandler->getData($request);

        $this->profileService->update($user, $profileDTO);

        return $this->redirectToRoute('profile');
    }

    #[Route('/profile/orders', name: 'order_history')]
    public function orderHistory(): Response
    {
        $user = $this->getUser();

        return $this->render(
            'profile/order_history.html.twig',
            ['orders' => $user->getOrders()]
        );
    }

    #[Route('/order/{id}', name: 'order_show')]
    public function show(Order $order): Response
    {
        return $this->render(
            'order/show.html.twig',
            ['order' => $order]
        );
    }
}
