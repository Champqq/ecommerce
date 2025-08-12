<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use App\Service\Product\Views\ProductViewsServiceInterface;
use App\Service\Storage\Manager\StorageManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductViewsServiceInterface $productService,
        private StorageManagerInterface $storageManager,
    ) {
    }

    #[Route('/product/{id}', name: 'product_show', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $this->productService->incrementViews($id);

        return $this->render(
            'product/show.html.twig', [
                'product' => $productRepository->find($id),
                'storageManager' => $this->storageManager,
            ]
        );
    }
}
