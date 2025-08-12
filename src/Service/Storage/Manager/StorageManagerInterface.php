<?php

declare(strict_types=1);

namespace App\Service\Storage\Manager;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface StorageManagerInterface
{
    public function uploadToStorage(UploadedFile $file): string;

    public function delete(string $path): void;

    public function getUrl(string $path): string;
}
