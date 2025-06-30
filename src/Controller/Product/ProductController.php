<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Repository\ProductRepository;
use App\Service\Product\ProductServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private ProductServiceInterface $productService,
    ) {
    }

    #[Route('/product/{id}', name: 'product_show', requirements: ['id' => '\d+'], methods: 'GET')]
    public function show(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        $this->productService->incrementViews($product);

        return $this->render(
            'product/show.html.twig', [
            'product' => $product
            ]
        );
    }
}
