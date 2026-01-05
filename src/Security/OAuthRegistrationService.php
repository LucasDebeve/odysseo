<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

final readonly class OAuthRegistrationService
{
    public function __construct(
        private UserRepository $userRepository,
    ) 
    {
    }

    /**
     * @param GoogleUser $resourceOwner
     */
    public function persist(ResourceOwnerInterface $resourceOwner): User 
    {
        $user = (new User())
                ->setGoogleId($resourceOwner->getId())
                ->setEmail($resourceOwner->getEmail())
                ->setNom($resourceOwner->getLastName())
                ->setPrenom($resourceOwner->getFirstName());

        $this->userRepository->add($user, true);
        return $user;
    }
}