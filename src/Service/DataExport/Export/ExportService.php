<?php

declare(strict_types=1);

namespace App\Service\DataExport\Export;

use App\Service\DataExport\Data\DataFetchServiceInterface;
use App\Service\DataExport\Dispatcher\ExportDispatcherInterface;
use App\Service\DataExport\Strategy\ExportStrategyInterface;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;

class ExportService implements ExportServiceInterface
{
    private array $strategies = [];

    public function __construct(
        private DataFetchServiceInterface $dataService,
        private ExportDispatcherInterface $dispatcher,
        iterable $exportStrategies,
    ) {
        foreach ($exportStrategies as $strategy) {
            $this->strategies[] = $strategy;
        }
    }

    public function export(string $entityType, string $format): Response
    {
        $this->dispatcher->dispatch($entityType, $format);

        $data = $this->dataService->fetchData($entityType);
        $strategy = $this->getStrategy($format);

        return $strategy->export($data, $entityType);
    }

    private function getStrategy(string $format): ExportStrategyInterface
    {
        foreach ($this->strategies as $strategy) {
            if ($strategy->supports($format)) {
                return $strategy;
            }
        }

        throw new InvalidArgumentException("Unsupported export format: $format");
    }
}
