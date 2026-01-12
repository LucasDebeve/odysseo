<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SecurityController extends AbstractController
{
    public const SCOPES = [
        'google' => [],
    ];

    #[Route('/login', name: 'auth_oauth_login', methods: ['GET'])]
    public function login(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_sejours');
        }

        return $this->render('login.html.twig');
    }

    #[Route('/logout', name: 'auth_oauth_logout', methods: ['GET'])]
    public function logout(): Response
    {
        throw new \RuntimeException('Not implemented');
    }

    #[Route('/oauth/connect/{service}', name: 'auth_oauth_connect', methods: ['GET'])]
    public function connect(string $service, ClientRegistry $clientRegistry): RedirectResponse 
    {
        if (!in_array($service, array_keys(self::SCOPES), true)) {
            throw $this->createNotFoundException();
        }

        return $clientRegistry->getClient($service)->redirect(self::SCOPES[$service], []);
    }

    #[Route('oauth/check/{service}', name: 'auth_oauth_check', methods: ['GET'])]
    public function check(): Response
    {
        return new Response(status: 200);
    }
}
