<?php

declare(strict_types=1);

namespace App\Controller\OAuth\GitHub;

use App\Security\LoginFormAuthenticator;
use App\Service\OAuth\Provider\GitHub\GitHubOAuthProviderInterface;
use App\Service\OAuth\Connector\OAuthConnectorInterface;
use GuzzleHttp\Exception\GuzzleException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class GitHubOAuthController extends AbstractController
{
    public function __construct(
        private OAuthConnectorInterface $oauthConnector,
        private UserAuthenticatorInterface $userAuthenticator,
        private LoginFormAuthenticator $loginFormAuthenticator,
        private GitHubOAuthProviderInterface $oauth,
    ) {
    }

    #[Route('/auth/github', name: 'oauth_login_github', methods: ['GET'])]
    public function githubRedirect(Request $request): Response
    {
        $url = $this->oauth->getProvider()->getAuthorizationUrl();

        $request->getSession()->set('oauth_state', $this->oauth->getProvider()->getState());

        return $this->redirect($url);
    }

    /**
     * @throws GuzzleException
     * @throws IdentityProviderException
     */
    #[Route('/auth/github/callback', name: 'oauth_callback_github', methods: ['GET'])]
    public function githubCallback(Request $request): Response
    {
        $provider = $this->oauth->getProvider();

        $token = $provider->getAccessToken(
            'authorization_code',
            ['code' => $request->get('code'),]
        );

        $resourceOwner = $provider->getResourceOwner($token);

        $user = $this->oauthConnector->connectGitHubOAuth($resourceOwner->getEmail(), $resourceOwner->getId());

        $this->userAuthenticator->authenticateUser($user, $this->loginFormAuthenticator, $request);

        return $this->redirectToRoute('homepage');
    }
}
