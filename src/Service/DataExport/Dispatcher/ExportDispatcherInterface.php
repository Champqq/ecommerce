<?php

declare(strict_types = 1);

namespace App\Service\DataExport\Dispatcher;

interface ExportDispatcherInterface
{
    public function dispatch(string $entityType, string $format): void;
}
