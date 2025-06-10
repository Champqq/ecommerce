<?php

declare(strict_types = 1);

namespace App\Service\Homepage;

use App\DTO\HomepageDTO;

interface HomepageServiceInterface
{
    public function getViewData(HomepageDTO $filterData): array;
}
