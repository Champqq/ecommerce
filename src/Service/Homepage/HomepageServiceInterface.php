<?php

declare(strict_types = 1);

namespace App\Service\Homepage;

use App\DTO\FilterDTO;

interface HomepageServiceInterface
{
    public function getViewData(FilterDTO $filterData): array;
}
