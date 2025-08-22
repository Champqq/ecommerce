<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Category;
use Symfony\Component\Routing\Attribute\Route;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin panel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Main', 'fa fa-home');

        yield MenuItem::section('Manage');
        yield MenuItem::linkToCrud('Users', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Products', 'fas fa-boxes', Product::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-list', Order::class);

        yield MenuItem::section('Data');
        yield MenuItem::linkToRoute('Export', 'fas fa-database', 'admin_export_form');

        yield MenuItem::section('Test');
        yield MenuItem::linkToRoute('Homepage', 'fas fa-home', 'homepage');
    }
}
