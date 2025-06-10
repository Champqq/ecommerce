<?php

declare(strict_types=1);

namespace App\Service\Profile\Request;

use App\DTO\ProfileUpdateDTO;
use Symfony\Component\HttpFoundation\Request;

interface ProfileRequestHandlerInterface
{
    public function getData(Request $request): ProfileUpdateDTO;
}
