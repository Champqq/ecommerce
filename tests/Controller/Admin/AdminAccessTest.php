<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\Tests\Controller\AbstractTestCase;

final class AdminAccessTest extends AbstractTestCase
{
    public function testAdminPanelAccess(): void
    {
        $client = AdminAccessTest::createClient();

        $user = $this->setupAdmin();

        $client->loginUser($user);

        $client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
    }
}
