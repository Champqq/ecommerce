<?php

declare(strict_types = 1);

namespace App\Tests\Controller;

final class HomepageControllerTest extends AbstractTestCase
{
    public function testIndex(): void
    {
        $client = HomepageControllerTest::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();
    }

    public function testIndexWithFilters(): void
    {
        $client = HomepageControllerTest::createClient();
        $client->request(
            'GET', '/', [
            'category_name' => 'shoes',
            'min_price' => 50,
            'max_price' => 200,
            'size' => '43',
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Filters');
    }
}
