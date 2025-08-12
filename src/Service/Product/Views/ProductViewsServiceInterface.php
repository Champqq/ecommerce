<?php

declare(strict_types=1);

namespace App\Service\Product\Views;

interface ProductViewsServiceInterface
{
    public function incrementViews(int $productId): void;
}
