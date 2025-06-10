<?php

declare(strict_types=1);

namespace App\Service\Checkout\Request;

use Symfony\Component\HttpFoundation\Request;

interface EmailHandlerInterface
{
    public function handleEmail(Request $request): string;
}
