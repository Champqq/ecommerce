<?php

declare(strict_types=1);

namespace App\Controller\Admin\Order;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideWhenUpdating(),
            TextField::new('number')->hideWhenUpdating(),
            TextField::new('customer_email')->hideWhenUpdating(),
            TextField::new('status'),

            ArrayField::new('items')
                ->setTemplatePath('admin/field/order-items.html.twig')
                ->onlyOnDetail(),

            Field::new('total')
                ->setTemplatePath('admin/field/money.html.twig')
                ->formatValue(
                    function ($value) {
                        return $value;
                    }
                ),
        ];
    }
}
