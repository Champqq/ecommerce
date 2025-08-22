<?php

declare(strict_types = 1);

namespace App\Service\DataExport\Export;

use Symfony\Component\HttpFoundation\Response;

interface ExportServiceInterface
{
    public function export(string $entityType, string $format): Response;
}
