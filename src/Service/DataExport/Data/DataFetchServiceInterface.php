<?php

declare(strict_types=1);

namespace App\Service\DataExport\Data;

interface DataFetchServiceInterface
{
    public function fetchData(string $entityType): array;
}
