<?php

declare(strict_types=1);

namespace App\Controller\Admin\DataExport\Download;

use App\Message\ExportMessage;
use App\Service\DataExport\Export\ExportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class DownloadAction extends AbstractController
{
    public function __construct(
        private ExportServiceInterface $exportService,
        private MessageBusInterface $bus,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    #[Route('/admin/export/download', name: 'admin_export_download', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $entity = $request->query->get('entity');
        $format = $request->query->get('format');

        $this->bus->dispatch(new ExportMessage($entity, $format));

        return $this->exportService->export($entity, $format);
    }
}
