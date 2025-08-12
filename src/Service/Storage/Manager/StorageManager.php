<?php

declare(strict_types=1);

namespace App\Service\Storage\Manager;

use App\Service\Storage\Factory\StorageFactoryInterface;
use League\Flysystem\FilesystemException;
use Random\RandomException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorageManager implements StorageManagerInterface
{
    public function __construct(
        private StorageFactoryInterface $storageFactory,
        private string $awsEndpoint,
        private string $awsBucket,
        private string $directory,
    ) {
    }

    /**
     * @throws RandomException
     * @throws FilesystemException
     */
    public function uploadToStorage(UploadedFile $file): string
    {
        $extension = $file->guessExtension() ?: 'bin';
        $filename = bin2hex(random_bytes(8)) . '.' . $extension;
        $path = $this->directory . '/' . $filename;

        $stream = fopen($file->getPathname(), 'r');
        $this->storageFactory->getStorage()->writeStream($path, $stream);
        fclose($stream);

        return $path;
    }

    /**
     * @throws FilesystemException
     */
    public function delete(string $path): void
    {
        if ($this->storageFactory->getStorage()->fileExists($path)) {
            $this->storageFactory->getStorage()->delete($path);
        }
    }

    public function getUrl(string $path): string
    {
        if ($this->storageFactory->isS3()) {
            return sprintf('%s/%s/%s', $this->awsEndpoint, $this->awsBucket, $path);
        } else {
            return sprintf('%s/%s', $this->directory, $path);
        }
    }
}
