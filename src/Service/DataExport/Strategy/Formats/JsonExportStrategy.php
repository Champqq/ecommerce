<?php

declare(strict_types = 1);

namespace App\Service\DataExport\Strategy\Formats;

use App\Service\DataExport\Strategy\ExportStrategyInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class JsonExportStrategy implements ExportStrategyInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function export(array $data, string $entityType): Response
    {
        $content = $this->serializer->serialize($data, 'json');

        return new Response(
            $content,
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $entityType . '.json"',
            ]
        );
    }

    public function supports(string $format): bool
    {
        return $format === 'json';
    }
}
