<?php

declare(strict_types=1);

namespace App\Service\OAuth\Connector;

use App\Entity\User;

interface OAuthConnectorInterface
{
    public function connectGoogleOAuth(string $email, string $oauthId): User;
    public function connectGitHubOAuth(string $email, int $oauthId): User;
}
