<?php

declare(strict_types=1);

namespace App\Tests\Controller\OAuth;

use App\Entity\User;
use App\Service\OAuth\Connector\OAuthConnectorInterface;
use App\Service\OAuth\Provider\Google\GoogleOAuthProviderInterface;
use App\Tests\Controller\AbstractTestCase;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class GoogleOAuthControllerTest extends AbstractTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testGoogleRedirect(): void
    {
        $googleProvider = $this->createMock(Google::class);
        $googleProvider->method('getAuthorizationUrl')->willReturn('https://test.com/oauth');
        $googleProvider->method('getState')->willReturn('testState');

        $oauth = $this->createMock(GoogleOAuthProviderInterface::class);
        $oauth->method('getProvider',)->willReturn($googleProvider);

        static::getContainer()->set(GoogleOAuthProviderInterface::class, $oauth);

        $this->client->request('GET', '/auth/google');

        $this->assertResponseRedirects('https://test.com/oauth');
    }

    public function testGoogleCallback(): void
    {
        $googleProvider = $this->createMock(Google::class);
        $token = $this->createMock(AccessToken::class);
        $resourceOwner = $this->createMock(GoogleUser::class);

        $googleProvider->method('getAccessToken')->willReturn($token);
        $googleProvider->method('getResourceOwner')->willReturn($resourceOwner);

        $resourceOwner->method('getEmail')->willReturn('test@example.com');
        $resourceOwner->method('getId')->willReturn('googleId');

        $oauth = $this->createMock(GoogleOAuthProviderInterface::class);
        $oauth->method('getProvider',)->willReturn($googleProvider);

        static::getContainer()->set(GoogleOAuthProviderInterface::class, $oauth);

        $user = $this->createMock(User::class);

        $oauthConnector = $this->createMock(OAuthConnectorInterface::class);
        $oauthConnector->method('connectGoogleOAuth')->with('test@example.com', 'googleId')->willReturn($user);

        static::getContainer()->set(OAuthConnectorInterface::class, $oauthConnector);

        $userAuthenticator = $this->createMock(UserAuthenticatorInterface::class);
        $userAuthenticator->method('authenticateUser')->willReturn(null);

        static::getContainer()->set(UserAuthenticatorInterface::class, $userAuthenticator);

        $this->client->request('GET', '/auth/google/callback?code=test-code');

        $this->assertResponseRedirects('/');
    }
}
