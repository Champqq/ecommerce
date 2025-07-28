<?php

declare(strict_types=1);

namespace App\Service\OAuth\Connector;

use App\DTO\OAuthUserDTO;
use App\Entity\User;
use App\Service\OAuth\Provider\OAuthProvider;

class OAuthConnector extends AbstractOAuthConnector implements OAuthConnectorInterface
{
    public function connectGoogleOAuth(string $email, string $oauthId): User
    {
        return $this->connectOAuth(new OAuthUserDTO($email, $oauthId, OAuthProvider::GOOGLE));
    }

    public function connectGitHubOAuth(string $email, int $oauthId): User
    {
        return $this->connectOAuth(new OAuthUserDTO($email, $oauthId, OAuthProvider::GITHUB));
    }
}
