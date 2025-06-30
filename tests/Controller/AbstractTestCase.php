<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Tests\Controller\Admin\AdminAccessTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestCase extends WebTestCase
{
    protected function setupProduct(): Product
    {
        $product = new Product();
        $product->setName('Test Product')
            ->setPrice(100);

        $em = static::getContainer()->get('doctrine')->getManager();
        $em->persist($product);
        $em->flush();

        return $product;
    }

    protected function setupAdmin(): User
    {
        $user = new User();
        $user->setEmail('admin@test.com')
            ->setPassword('password')
            ->setRoles(['ROLE_ADMIN']);

        $em = AdminAccessTest::getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }
}
