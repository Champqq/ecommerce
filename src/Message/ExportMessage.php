<?php

declare(strict_types=1);

namespace App\Message;

class ExportMessage
{
    public function __construct(
        public string $entityType,
        public string $format,
    ) {
    }
}
