<?php

declare(strict_types=1);

namespace App\Service\Checkout\Request;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

class EmailHandler implements EmailHandlerInterface
{
    public function __construct(private Security $security)
    {
    }

    public function handleEmail(Request $request): string
    {
        if ($this->security->getUser()) {
            return $this->security->getUser()->getEmail();
        } else {
            return $request->request->get('email');
        }
    }
}
