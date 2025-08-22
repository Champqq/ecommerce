<?php

declare(strict_types = 1);

namespace App\Service\DataExport\Strategy;

use Symfony\Component\HttpFoundation\Response;

interface ExportStrategyInterface
{
    public function export(array $data, string $entityType): Response;
    public function supports(string $format): bool;
}
