<?php

declare(strict_types = 1);

namespace App\DTO\Export;

use App\Entity\Product;

final readonly class ProductExportDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public string $price,
        public array $categories,
        public array $attributes,
        public int $views,
        public ?string $image,
    ) {
    }

    public static function fromEntity(Product $product): self
    {
        $categories = [];
        foreach ($product->getCategories() as $category) {
            $categories[] = [
                'category' => $category->getName(),
            ];
        }

        $attributes = [];
        foreach ($product->getAttributes() as $attribute) {
            $attributes[] = [
                'name' => $attribute->getName(),
                'value' => $attribute->getValue(),
            ];
        }

        return new self(
            id: $product->getId(),
            name: $product->getName(),
            description: $product->getDescription(),
            price: $product->getPrice()->getAmount(),
            categories: $categories,
            attributes: $attributes,
            views: $product->getViews(),
            image: $product->getImage(),
        );
    }
}
