<?php

declare(strict_types=1);

namespace App\Service\OAuth\Provider\GitHub;

use League\OAuth2\Client\Provider\Github;

interface GitHubOAuthProviderInterface
{
    public function getProvider(): Github;
}
