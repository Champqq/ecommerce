<?php

declare(strict_types=1);

namespace App\Service\Homepage\Request;

use App\DTO\HomepageDTO;
use Symfony\Component\HttpFoundation\Request;

interface HomepageDataHandlerInterface
{
    public function getFilterData(Request $request): HomepageDTO;
}
