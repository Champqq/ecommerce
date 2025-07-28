<?php

declare(strict_types = 1);

namespace App\DTO;

use App\Service\OAuth\Provider\OAuthProvider;

class OAuthUserDTO
{
    public function __construct(
        public string $email,
        public string|int $oauthId,
        public OAuthProvider $provider,
    ) {
    }
}
