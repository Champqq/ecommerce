<?php

declare(strict_types=1);

namespace App\Service\Homepage;

use App\DTO\FilterDTO;
use App\Repository\ProductRepository;
use App\Service\Storage\Manager\StorageManagerInterface;

class HomepageService implements HomepageServiceInterface
{
    public function __construct(
        private ProductRepository $productRepository,
        private StorageManagerInterface $storageManager,
    ) {
    }

    public function getViewData(FilterDTO $filterData): array
    {
        if (!$filterData) {
            $products = $this->productRepository->findAll();
        } else {
            $products = $this->productRepository->searchWithFilters(
                $filterData->getCategory(),
                $filterData->getMinPrice(),
                $filterData->getMaxPrice(),
                $filterData->getSize()
            );
        }

        $latest = $this->productRepository->findLatest();
        $popular = $this->productRepository->findPopular();

        return [
            'products' => $products,
            'latest' => $latest,
            'popular' => $popular,
            'storageManager' => $this->storageManager,
        ];
    }
}
