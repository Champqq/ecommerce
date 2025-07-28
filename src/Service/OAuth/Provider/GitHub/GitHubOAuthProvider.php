<?php

declare(strict_types=1);

namespace App\Service\OAuth\Provider\GitHub;

use League\OAuth2\Client\Provider\Github;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class GitHubOAuthProvider implements GitHubOAuthProviderInterface
{
    private Github $provider;

    public function __construct(string $clientId, string $clientSecret, RouterInterface $router)
    {
        $this->provider = new Github(
            ['clientId'     => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri'  => $router->generate('oauth_callback_github', [], UrlGeneratorInterface::ABSOLUTE_URL),]
        );
    }

    public function getProvider(): Github
    {
        return $this->provider;
    }
}
