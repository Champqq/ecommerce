<?php

declare(strict_types=1);

namespace App\Controller\Admin\Product;

use App\Entity\Product;
use App\Form\MoneyValueObjectType;
use App\Form\ProductAttributeType;
use App\Service\Product\Image\ProductImageServiceInterface;
use App\Service\Storage\Manager\StorageManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
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
use InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductCrudController extends AbstractCrudController
{
    public function __construct(
        private StorageManagerInterface $storageManager,
        private ProductImageServiceInterface $productImageService,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->disable(Action::DELETE);
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

            TextField::new('imageFile')
                ->setFormType(FileType::class)
                ->setFormTypeOptions(
                    [
                    'mapped' => false,
                    'required' => false,
                    'attr' => ['accept' => 'image/*']
                    ]
                )
                ->onlyOnForms(),

            ImageField::new('image', 'Image')
                ->formatValue(
                    function ($value, Product $entity) {
                        return $this->storageManager->getUrl($value ?: '');
                    }
                )
                ->hideOnForm(),

            Field::new('price')
                ->setFormType(MoneyValueObjectType::class)
                ->setLabel('Price')
                ->setFormTypeOption('currency', 'USD')
                ->onlyOnForms(),

            Field::new('price')
                ->setTemplatePath('admin/field/money.html.twig')
                ->formatValue(
                    function ($value) {
                        return $value;
                    }
                )
            ->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Product) {
            throw new InvalidArgumentException('Expected instance of Product.');
        }

        $uploadedFile = $this->getUploadedFile();
        $this->productImageService->saveProductWithFile($entityInstance, $uploadedFile);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->persistEntity($entityManager, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Product && $entityInstance->getImage()) {
            $this->storageManager->delete($entityInstance->getImage());
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }

    private function getUploadedFile(): ?UploadedFile
    {
        $request = $this->getContext()->getRequest();
        return $request->files->get('Product')['imageFile'] ?? null;
    }
}
