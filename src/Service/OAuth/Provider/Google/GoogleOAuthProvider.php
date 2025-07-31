<?php

declare(strict_types=1);

namespace App\Service\OAuth\Provider\Google;

use League\OAuth2\Client\Provider\Google;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class GoogleOAuthProvider implements GoogleOAuthProviderInterface
{
    private Google $provider;

    public function __construct(string $clientId, string $clientSecret, RouterInterface $router)
    {
        $this->provider = new Google(
            [
            'clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri'  => $router->generate('oauth_callback_google', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'hostedDomain' => null,
            ]
        );
    }

    public function getProvider(): Google
    {
        return $this->provider;
    }
}
