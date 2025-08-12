<?php

declare(strict_types=1);

namespace App\Tests\Service\Storage;

use App\Service\Storage\Factory\StorageFactory;
use App\Service\Storage\Manager\StorageManager;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\InMemory\InMemoryFilesystemAdapter;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class StorageManagerTest extends WebTestCase
{
    /**
     * @throws FilesystemException|RandomException
     */
    public function testUploadToStorageAndDelete(): void
    {
        $localStorage = new Filesystem(new InMemoryFilesystemAdapter());
        $s3Storage = new Filesystem(new InMemoryFilesystemAdapter());

        $storageFactory = new StorageFactory($localStorage, $s3Storage, 's3');

        $storageManager = new StorageManager(
            $storageFactory,
            'http://test',
            'my-test-bucket',
            'test'
        );

        $tempFile = tempnam(sys_get_temp_dir(), 'upload_test_');
        file_put_contents($tempFile, 'test content');

        $uploadedFile = new UploadedFile(
            $tempFile,
            'test.txt',
            'text/plain',
            null,
            true
        );

        $path = $storageManager->uploadToStorage($uploadedFile);

        $this->assertStringStartsWith('test/', $path);
        $this->assertTrue($s3Storage->fileExists($path));
        $this->assertSame('test content', $s3Storage->read($path));

        $storageManager->delete($path);

        $this->assertFalse($localStorage->fileExists($path));
    }

    public function testGetUrl(): void
    {
        $localStorage = new Filesystem(new InMemoryFilesystemAdapter());
        $s3Storage = new Filesystem(new InMemoryFilesystemAdapter());

        $factoryLocal = new StorageFactory($localStorage, $s3Storage, 'local');
        $localManager = new StorageManager($factoryLocal, 'http://test', 'my-test-bucket', '/test');

        $urlLocal = $localManager->getUrl('test.jpg');
        $this->assertEquals('/test/test.jpg', $urlLocal);

        $factoryS3 = new StorageFactory($localStorage, $s3Storage, 's3');
        $s3Manager = new StorageManager($factoryS3, 'http://test', 'my-test-bucket', '/test');

        $urlS3 = $s3Manager->getUrl('test.jpg');
        $this->assertEquals('http://test/my-test-bucket/test.jpg', $urlS3);
    }
}
