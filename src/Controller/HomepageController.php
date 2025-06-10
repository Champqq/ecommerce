<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Homepage\HomepageServiceInterface;
use App\Service\Homepage\Request\HomepageDataHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private HomepageServiceInterface $homepageService,
        private HomepageDataHandlerInterface $homepageDataHandler,
    ) {
    }

    #[Route('/', name: 'homepage')]
    public function index(Request $request): Response
    {
        $filterData = $this->homepageDataHandler->getFilterData($request);

        return $this->render(
            'homepage/index.html.twig',
            $this->homepageService->getViewData($filterData)
        );
    }
}
