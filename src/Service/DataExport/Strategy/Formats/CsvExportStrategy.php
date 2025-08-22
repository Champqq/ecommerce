<?php

declare(strict_types=1);

namespace App\Service\DataExport\Strategy\Formats;

use App\Service\DataExport\Strategy\ExportStrategyInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class CsvExportStrategy implements ExportStrategyInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public function export(array $data, string $entityType): Response
    {
        $handle = fopen('php://temp', 'r+');

        try {
            if (!empty($data)) {
                $first = $this->serializer->normalize($data[0], 'array');
                fputcsv($handle, array_keys($first));

                foreach ($data as $item) {
                    $row = $this->serializer->normalize($item, 'array');
                    fputcsv($handle, $row);
                }
            }

            rewind($handle);
            $content = stream_get_contents($handle);
        } finally {
            fclose($handle);
        }

        return new Response(
            $content,
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $entityType . '.csv"',
            ]
        );
    }

    public function supports(string $format): bool
    {
        return $format === 'csv';
    }
}
