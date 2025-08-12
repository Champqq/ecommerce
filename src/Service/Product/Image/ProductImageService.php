<?php

declare(strict_types = 1);

namespace App\Service\Product\Image;

use App\Entity\Product;
use App\Service\Entity\EntityServiceInterface;
use App\Service\Storage\Manager\StorageManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductImageService implements ProductImageServiceInterface
{
    public function __construct(
        private EntityServiceInterface $entityService,
        private StorageManagerInterface $storageManager,
    ) {
    }

    public function saveProductWithFile(Product $product, ?UploadedFile $uploadedFile): void
    {
        if ($uploadedFile !== null) {
            if ($product->getImage()) {
                $this->storageManager->delete($product->getImage());
            }

            $newPath = $this->storageManager->uploadToStorage($uploadedFile);
            $product->setImage($newPath);
        }

        $this->entityService->save($product);
    }
}
