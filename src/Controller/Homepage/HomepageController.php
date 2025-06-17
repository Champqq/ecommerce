<?php

declare(strict_types=1);

namespace App\Controller\Homepage;

use App\DTO\FilterDTO;
use App\Repository\CategoryRepository;
use App\Service\Homepage\HomepageServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    public function __construct(
        private HomepageServiceInterface $homepageService,
        private CategoryRepository $categoryRepository,
    ) {
    }

    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(Request $request): Response
    {
        $categoryName = $request->query->get('category');
        $minPrice = (float) $request->query->get('min_price');
        $maxPrice = (float) $request->query->get('max_price');
        $size = $request->query->get('size');

        $category = null;
        if ($categoryName) {
            $category = $this->categoryRepository->findCategory($categoryName);
        }

        $filterData = new FilterDTO($category, $minPrice, $maxPrice, $size);

        return $this->render(
            'homepage/index.html.twig',
            $this->homepageService->getViewData($filterData)
        );
    }
}
