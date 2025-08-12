<?php

declare(strict_types=1);

namespace App\Service\Product\Image;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ProductImageServiceInterface
{
    public function saveProductWithFile(Product $product, ?UploadedFile $uploadedFile): void;
}
