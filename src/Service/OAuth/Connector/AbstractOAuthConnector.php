<?php

declare(strict_types=1);

namespace App\Service\OAuth\Connector;

use App\DTO\OAuthUserDTO;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Entity\EntityServiceInterface;
use App\Service\OAuth\Provider\OAuthProvider;

class AbstractOAuthConnector
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityServiceInterface $entityService,
    ) {
    }

    protected function connectOAuth(OAuthUserDTO $userDTO): User
    {
        $user = $this->findUserByOAuthId($userDTO->oauthId, $userDTO->provider);

        if (!$user) {
            $user = $this->userRepository->findOneBy(['email' => $userDTO->email]);

            if ($user) {
                $this->setOAuthId($user, $userDTO->oauthId, $userDTO->provider);
            } else {
                $user = $this->createUserWithOAuth($userDTO);
            }

            $this->entityService->save($user);
        }

        return $user;
    }

    private function findUserByOAuthId(string|int $oauthId, OAuthProvider $provider): ?User
    {
        return match ($provider) {
            OAuthProvider::GOOGLE => $this->userRepository->findOneBy(['googleId' => $oauthId]),
            OAuthProvider::GITHUB => $this->userRepository->findOneBy(['githubId' => $oauthId]),
        };
    }

    private function setOAuthId(User $user, string|int $oauthId, OAuthProvider $provider): void
    {
        match ($provider) {
            OAuthProvider::GOOGLE => $user->setGoogleId($oauthId),
            OAuthProvider::GITHUB => $user->setGithubId($oauthId),
        };
    }

    private function createUserWithOAuth(OAuthUserDTO $oauthData): User
    {
        $user = new User();

        match ($oauthData->provider) {
            OAuthProvider::GOOGLE => $user->createWithGoogleOAuth($oauthData->email, $oauthData->oauthId),
            OAuthProvider::GITHUB => $user->createWithGitHubOAuth($oauthData->email, $oauthData->oauthId),
        };

        return $user;
    }
}
