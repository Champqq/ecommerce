<?php

declare(strict_types=1);

namespace App\Controller\Profile\Index;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexAction extends AbstractController
{
    #[Route('/profile', name: 'profile', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render('profile/index.html.twig');
    }
}
