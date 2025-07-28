<?php

declare(strict_types=1);

namespace App\Tests\Controller\OAuth;

use App\Entity\User;
use App\Service\OAuth\Connector\OAuthConnectorInterface;
use App\Service\OAuth\Provider\GitHub\GitHubOAuthProviderInterface;
use App\Tests\Controller\AbstractTestCase;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class GitHubOAuthControllerTest extends AbstractTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGitHubRedirect(): void
    {
        $githubProvider = $this->createMock(Github::class);
        $githubProvider->method('getAuthorizationUrl')->willReturn('https://test.com/oauth');
        $githubProvider->method('getState')->willReturn('testState');

        $oauth = $this->createMock(GitHubOAuthProviderInterface::class);
        $oauth->method('getProvider',)->willReturn($githubProvider);

        static::getContainer()->set(GitHubOAuthProviderInterface::class, $oauth);

        $this->client->request('GET', '/auth/github');

        $this->assertResponseRedirects('https://test.com/oauth');
    }

    public function testGitHubCallback(): void
    {
        $githubProvider = $this->createMock(Github::class);
        $token = $this->createMock(AccessToken::class);
        $resourceOwner = $this->createMock(GithubResourceOwner::class);

        $githubProvider->method('getAccessToken')->willReturn($token);
        $githubProvider->method('getResourceOwner')->willReturn($resourceOwner);

        $resourceOwner->method('getEmail')->willReturn('test@example.com');
        $resourceOwner->method('getId')->willReturn(12345);

        $oauth = $this->createMock(GitHubOAuthProviderInterface::class);
        $oauth->method('getProvider',)->willReturn($githubProvider);

        static::getContainer()->set(GitHubOAuthProviderInterface::class, $oauth);

        $user = $this->createMock(User::class);

        $oauthConnector = $this->createMock(OAuthConnectorInterface::class);
        $oauthConnector->method('connectGitHubOAuth')->with('test@example.com', 12345)->willReturn($user);

        static::getContainer()->set(OAuthConnectorInterface::class, $oauthConnector);

        $userAuthenticator = $this->createMock(UserAuthenticatorInterface::class);
        $userAuthenticator->method('authenticateUser')->willReturn(null);

        static::getContainer()->set(UserAuthenticatorInterface::class, $userAuthenticator);

        $this->client->request('GET', '/auth/github/callback?code=test-code');

        $this->assertResponseRedirects('/');
    }
}
