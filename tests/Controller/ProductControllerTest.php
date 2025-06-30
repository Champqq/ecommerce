<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Service\Product\ProductServiceInterface;

final class ProductControllerTest extends AbstractTestCase
{
    public function testShow(): void
    {
        $client = ProductControllerTest::createClient();

        $productService = $this->createMock(ProductServiceInterface::class);
        $productService->expects($this->once())->method('incrementViews');

        ProductControllerTest::getContainer()->set(ProductServiceInterface::class, $productService);

        $product = $this->setupProduct();

        $client->request('GET', '/product/' . $product->getId());

        $this->assertResponseIsSuccessful();
    }
}
