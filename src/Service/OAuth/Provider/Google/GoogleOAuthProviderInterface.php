<?php

declare(strict_types=1);

namespace App\Service\OAuth\Provider\Google;

use League\OAuth2\Client\Provider\Google;

interface GoogleOAuthProviderInterface
{
    public function getProvider(): Google;
}
