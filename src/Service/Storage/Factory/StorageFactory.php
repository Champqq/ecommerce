<?php

declare(strict_types=1);

namespace App\Service\Storage\Factory;

use League\Flysystem\FilesystemOperator;

class StorageFactory implements StorageFactoryInterface
{
    public function __construct(
        private FilesystemOperator $localStorage,
        private FilesystemOperator $s3Storage,
        private string $storageType,
    ) {
    }

    public function getStorage(): FilesystemOperator
    {
        return $this->storageType === 's3' ? $this->s3Storage : $this->localStorage;
    }

    public function isS3(): bool
    {
        return $this->storageType === 's3';
    }
}
