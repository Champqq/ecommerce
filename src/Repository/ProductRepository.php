<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findLatest(int $limit = 4): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findPopular(int $limit = 4): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.views', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function findProduct(int $id): Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function searchWithFilters(
        Category $category = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        string $size = null
    ): array {
        $qb = $this->createQueryBuilder('p')
            ->leftJoin('p.attributes', 'a')
            ->where('p.name LIKE :query')
            ->setParameter('query', '%');

        if ($category) {
            $qb->andWhere(':category MEMBER OF p.categories')
                ->setParameter('category', $category);
        }

        if ($minPrice) {
            $qb->andWhere('p.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);
        }

        if ($maxPrice) {
            $qb->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if ($size) {
            $qb->andWhere('a.value = :size')
                ->setParameter('size', $size);
        }

        return $qb->getQuery()->getResult();
    }
}
