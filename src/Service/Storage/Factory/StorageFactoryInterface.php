<?php

declare(strict_types=1);

namespace App\Service\Storage\Factory;

use League\Flysystem\FilesystemOperator;

interface StorageFactoryInterface
{
    public function getStorage(): FilesystemOperator;

    public function isS3(): bool;
}
