<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Category;

class FilterDTO
{
    private ?Category $category;
    private ?float $minPrice;
    private ?float $maxPrice;
    private ?string $size;

    public function __construct(
        ?Category $category,
        ?float $minPrice,
        ?float $maxPrice,
        ?string $size
    ) {
        $this->category = $category;
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
        $this->size = $size;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function getMinPrice(): ?float
    {
        return $this->minPrice;
    }

    public function getMaxPrice(): ?float
    {
        return $this->maxPrice;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }
}
