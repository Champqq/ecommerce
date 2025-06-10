<?php

declare(strict_types=1);

namespace App\Service\Profile\Request;

use App\DTO\ProfileUpdateDTO;
use Symfony\Component\HttpFoundation\Request;

class ProfileRequestHandler implements ProfileRequestHandlerInterface
{
    public function getData(Request $request): ProfileUpdateDTO
    {
        $profileDTO = new ProfileUpdateDTO();

        $profileDTO->setPhone($request->request->get('phone'));
        $profileDTO->setPassword($request->request->get('password'));

        return $profileDTO;
    }
}
