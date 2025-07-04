<?php

declare(strict_types=1);

namespace App\Service\Product;

interface ProductServiceInterface
{
    public function incrementViews(int $productId): void;
}
