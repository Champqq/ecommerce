<?php

declare(strict_types = 1);

namespace App\Service\Homepage\Request;

use App\DTO\HomepageDTO;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

class HomepageDataHandler implements HomepageDataHandlerInterface
{
    public function __construct(private CategoryRepository $categoryRepository)
    {
    }

    public function getFilterData(Request $request): HomepageDTO
    {
        $categoryName = $request->query->get('category');
        $minPrice = (float) $request->query->get('min_price');
        $maxPrice = (float) $request->query->get('max_price');
        $size = $request->query->get('size');

        $category = null;
        if ($categoryName) {
            $category = $this->categoryRepository->findCategory($categoryName);
        }

        return new HomepageDTO($category, $minPrice, $maxPrice, $size);
    }
}
