<?php

declare(strict_types=1);

namespace App\Controller\OAuth\Google;

use App\Security\LoginFormAuthenticator;
use App\Service\OAuth\Provider\Google\GoogleOAuthProviderInterface;
use App\Service\OAuth\Connector\OAuthConnectorInterface;
use GuzzleHttp\Exception\GuzzleException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class GoogleOAuthController extends AbstractController
{
    public function __construct(
        private OAuthConnectorInterface $oauthConnector,
        private UserAuthenticatorInterface $userAuthenticator,
        private LoginFormAuthenticator $loginFormAuthenticator,
        private GoogleOAuthProviderInterface $oauth,
    ) {
    }

    #[Route('/auth/google', name: 'oauth_login_google', methods: ['GET'])]
    public function googleRedirect(Request $request): Response
    {
        $url = $this->oauth->getProvider()->getAuthorizationUrl();

        $request->getSession()->set('oauth_state', $this->oauth->getProvider()->getState());

        return $this->redirect($url);
    }

    /**
     * @throws GuzzleException
     * @throws IdentityProviderException
     */
    #[Route('/auth/google/callback', name: 'oauth_callback_google', methods: ['GET'])]
    public function googleCallback(Request $request): Response
    {
        $provider = $this->oauth->getProvider();

        $token = $provider->getAccessToken(
            'authorization_code',
            ['code' => $request->get('code'),]
        );

        $resourceOwner = $provider->getResourceOwner($token);

        $user = $this->oauthConnector->connectGoogleOAuth($resourceOwner->getEmail(), $resourceOwner->getId());

        $this->userAuthenticator->authenticateUser($user, $this->loginFormAuthenticator, $request);

        return $this->redirectToRoute('homepage');
    }
}
