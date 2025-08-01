<?php

declare(strict_types=1);

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\ProductAttributeType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            TextField::new('description')->hideOnIndex(),
            IntegerField::new('views')->onlyOnDetail(),
            AssociationField::new('categories')->onlyOnForms(),
            ArrayField::new('categories')
                ->formatValue(
                    function ($value, $entity) {
                        return implode(
                            ', ', $entity->getCategories()->map(
                                function ($category) {
                                    return $category->getName();
                                }
                            )->toArray()
                        );
                    }
                )
                ->onlyOnDetail(),

            CollectionField::new('attributes')
                ->allowAdd()
                ->allowDelete()
                ->setEntryType(ProductAttributeType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),

            ArrayField::new('attributes')
                ->setTemplatePath('admin/field/attributes.html.twig')
                ->onlyOnDetail(),

            ImageField::new('image')
                ->setBasePath('/uploads/products')
                ->setUploadDir('public/uploads/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

            Field::new('price')
                ->setTemplatePath('admin/field/money.html.twig')
                ->formatValue(function ($value) {
                    return $value;
                }),
        ];
    }
}
