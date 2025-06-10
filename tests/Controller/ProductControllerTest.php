<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ProductControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = ProductControllerTest::createClient();
        $client->request('GET', '/product');

        self::assertResponseIsSuccessful();
    }
}
