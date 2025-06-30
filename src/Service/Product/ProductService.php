<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Entity\Product;
use App\Service\Entity\EntityServiceInterface;

class ProductService implements ProductServiceInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
    ) {
    }

    public function incrementViews(Product $product): void
    {
        $product->incrementViews();
        $this->entityService->save($product);
    }
}
