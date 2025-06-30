<?php

declare(strict_types=1);

namespace App\Tests\Controller;

final class CartControllerTest extends AbstractTestCase
{
    public function testIndex(): void
    {
        $client = CartControllerTest::createClient();
        $client->request('GET', '/cart');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Cart');
    }

    public function testAdd(): void
    {
        $client = CartControllerTest::createClient();

        $product =$this->setupProduct();

        $client->request(
            'POST', '/cart/add/' . $product->getId(), [
            'size' => 'M',
            'quantity' => 1,
            ]
        );

        $this->assertResponseRedirects('/cart');
    }

    public function testRemove(): void
    {
        $client = CartControllerTest::createClient();

        $product =$this->setupProduct();

        $client->request('POST', '/cart/remove/' . $product->getId());

        $this->assertResponseRedirects('/cart');
    }

    public function testClear(): void
    {
        $client = CartControllerTest::createClient();
        $client->request('POST', '/cart/clear');

        $this->assertResponseRedirects('/cart');
    }

    public function testUpdateQuantity(): void
    {
        $client = CartControllerTest::createClient();

        $product =$this->setupProduct();

        $client->request(
            'POST', '/cart/update/' . $product->getId(), [
            'quantity' => 3,
            ]
        );

        $this->assertResponseStatusCodeSame(204);
    }
}
