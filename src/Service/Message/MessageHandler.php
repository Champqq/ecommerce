<?php

declare(strict_types=1);

namespace App\Service\Message;

use App\Message\ExportMessage;
use App\Service\DataExport\Export\ExportServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class MessageHandler
{
    public function __construct(
        private ExportServiceInterface $exportService,
        private string $exportDirectory,
    ) {
    }

    public function __invoke(ExportMessage $message): void
    {
        $response = $this->exportService->export($message->entityType, $message->format);

        $filename = sprintf(
            '%s/%s_%d.%s',
            $this->exportDirectory,
            $message->entityType,
            time(),
            $message->format,
        );

        file_put_contents($filename, $response->getContent());
    }
}
