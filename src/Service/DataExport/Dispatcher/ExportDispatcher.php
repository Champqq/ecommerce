<?php

declare(strict_types=1);

namespace App\Service\DataExport\Dispatcher;

use App\Message\ExportMessage;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ExportDispatcher implements ExportDispatcherInterface
{
    public function __construct(
        private MessageBusInterface $bus
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function dispatch(string $entityType, string $format): void
    {
        $this->bus->dispatch(new ExportMessage($entityType, $format));
    }
}
