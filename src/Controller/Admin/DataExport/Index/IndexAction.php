<?php

declare(strict_types=1);

namespace App\Controller\Admin\DataExport\Index;

use App\DTO\Export\ExportConfigDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexAction extends AbstractController
{
    public function __construct(
        private ExportConfigDTO $config,
    ) {
    }

    #[Route('/admin/export', name: 'admin_export_form', methods: ['GET'])]
    public function __invoke(): Response
    {
        return $this->render(
            'admin/export.html.twig', [
                'entities' => $this->config->entities,
                'formats'  => $this->config->formats,
            ]
        );
    }
}
