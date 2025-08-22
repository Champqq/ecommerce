<?php

declare(strict_types=1);

namespace App\Service\DataExport\Data;

use App\DTO\Export\OrderExportDTO;
use App\DTO\Export\ProductExportDTO;
use App\DTO\Export\UserExportDTO;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

final class DataFetchService implements DataFetchServiceInterface
{
    /**
     * @var array<string, array{class-string, class-string}>
     */
    private const ENTITY_MAP = [
        'products' => [Product::class, ProductExportDTO::class],
        'orders'   => [Order::class, OrderExportDTO::class],
        'users'    => [User::class, UserExportDTO::class],
    ];

    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function fetchData(string $entityType): array
    {
        [$entityClass, $dtoClass] = self::ENTITY_MAP[$entityType];

        $query = $this->em->createQueryBuilder()
            ->select('e')
            ->from($entityClass, 'e')
            ->getQuery()
            ->toIterable();

        $result = [];
        foreach ($query as $entity) {
            $result[] = $dtoClass::fromEntity($entity);
        }

        return $result;
    }
}
