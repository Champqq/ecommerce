<?php

declare(strict_types=1);

namespace App\Controller\Profile\Update;

use App\DTO\ProfileUpdateDTO;
use App\Service\Profile\ProfileServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UpdateAction extends AbstractController
{
    public function __construct(
        private ProfileServiceInterface $profileService
    ) {
    }

    #[Route('/profile/update', name: 'profile_update', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        $user = $this->getUser();

        $profileDTO = new ProfileUpdateDTO();

        $profileDTO->setPhone($request->request->get('phone'));
        $profileDTO->setPassword($request->request->get('password'));

        $this->profileService->update($user, $profileDTO);

        return $this->redirectToRoute('profile');
    }
}
