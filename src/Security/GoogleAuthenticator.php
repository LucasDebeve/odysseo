<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
* @see https://symfony.com/doc/current/security/custom_authenticator.html
*/
class GoogleAuthenticator extends AbstractOAuthAuthenticator
{
    protected string $serviceName = 'google';

    protected function getUserFromResourceOwner(ResourceOwnerInterface $resourceOwner, UserRepository $userRepository): ?User 
    {
        if (!$resourceOwner instanceof GoogleUser) {
            throw new \RuntimeException('Expect google user');
        }

        if (true !== $resourceOwner->getEmailVerified()) {
            throw new AuthenticationException('Email not verified');
        }

        return $userRepository->findOneBy([
            'google_id' => $resourceOwner->getId(),
            'email' => $resourceOwner->getEmail(),
        ]);
    }
}
