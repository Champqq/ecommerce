<?php

declare(strict_types=1);

namespace App\Tests\Service\Storage;

use App\Service\Storage\Factory\StorageFactory;
use League\Flysystem\FilesystemOperator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StorageFactoryTest extends WebTestCase
{
    public function testGetStorageLocal(): void
    {
        $localStorage = $this->createMock(FilesystemOperator::class);
        $s3Storage = $this->createMock(FilesystemOperator::class);

        $storageFactory = new StorageFactory($localStorage, $s3Storage, 'local');

        $this->assertSame($localStorage, $storageFactory->getStorage());
        $this->assertFalse($storageFactory->isS3());
    }

    public function testGetStorageS3(): void
    {
        $localStorage = $this->createMock(FilesystemOperator::class);
        $s3Storage = $this->createMock(FilesystemOperator::class);

        $storageFactory = new StorageFactory($localStorage, $s3Storage, 's3');

        $this->assertSame($s3Storage, $storageFactory->getStorage());
        $this->assertTrue($storageFactory->isS3());
    }
}
