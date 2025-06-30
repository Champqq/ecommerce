<?php

declare(strict_types=1);

namespace App\Service\Product;

use App\Entity\Product;

interface ProductServiceInterface
{
    public function incrementViews(Product $product): void;
}
