<?php

declare(strict_types=1);

namespace App\DTO\Export;

final readonly class ExportConfigDTO
{
    /**
     * @param string[] $entities
     * @param string[] $formats
     */
    public function __construct(
        public array $entities,
        public array $formats,
    ) {
    }
}
