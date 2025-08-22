<?php

declare(strict_types=1);

namespace App\Tests\Service\DataExport;

use App\Service\DataExport\Data\DataFetchServiceInterface;
use App\Service\DataExport\Export\ExportService;
use App\Service\DataExport\Strategy\Formats\CsvExportStrategy;
use App\Service\DataExport\Strategy\Formats\JsonExportStrategy;
use App\Service\DataExport\Strategy\Formats\XmlExportStrategy;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;

class ExportServiceTest extends TestCase
{
    private DataFetchServiceInterface $dataFetchService;
    private ExportService $service;

    protected function setUp(): void
    {
        $this->dataFetchService = $this->createMock(DataFetchServiceInterface::class);

        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder(), new XmlEncoder()]);

        $strategyCsv = new CsvExportStrategy($serializer);
        $strategyJson = new JsonExportStrategy($serializer);
        $strategyXml = new XmlExportStrategy($serializer);

        $this->service = new ExportService(
            $this->dataFetchService,
            [$strategyCsv, $strategyJson, $strategyXml]
        );
    }

    public function testCsvExport(): void
    {
        $data = [
            ['id' => 1, 'name' => 'Test product'],
            ['id' => 2, 'name' => 'Another product'],
        ];

        $this->dataFetchService->method('fetchData')->with('products')->willReturn($data);

        $response = $this->service->export('products', 'csv');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString("id,name\n1,\"Test product\"", $response->getContent());
        $this->assertStringContainsString("2,\"Another product\"", $response->getContent());
    }

    public function testJsonExportWithEmptyDataset(): void
    {
        $data = [];
        $this->dataFetchService->method('fetchData')->with('products')->willReturn($data);

        $response = $this->service->export('products', 'json');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertSame('[]', trim($response->getContent()));
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }

    public function testXmlExportWithLargeDataset(): void
    {
        $data = array_map(fn($i) => ['id' => $i, 'total' => $i * 10], range(1, 1000));
        $this->dataFetchService->method('fetchData')->with('orders')->willReturn($data);

        $response = $this->service->export('orders', 'xml');

        $this->assertInstanceOf(Response::class, $response);
        $this->assertStringContainsString('<id>1</id>', $response->getContent());
        $this->assertStringContainsString('<id>1000</id>', $response->getContent());
        $this->assertSame('application/xml', $response->headers->get('Content-Type'));
    }

    public function testUnsupportedFormatThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Unsupported export format: pdf');

        $this->service->export('products', 'pdf');
    }
}
