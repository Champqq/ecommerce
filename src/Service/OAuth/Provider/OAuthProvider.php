<?php

declare(strict_types=1);

namespace App\Service\OAuth\Provider;

enum OAuthProvider: string
{
    case GOOGLE = 'google';
    case GITHUB = 'github';
}
