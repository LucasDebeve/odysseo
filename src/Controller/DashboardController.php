<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    #[Route('/me', name: 'app_my_profile', methods: ['GET'])]
    public function myProfile(): Response
    {
        return $this->render('dashboard/profile.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/{id}', name: 'app_profile', methods: ['GET'])]
    public function profile(
        #[MapEntity(expr: 'repository.findWithDiplomes(id)')] User $user,
    ): Response
    {
        return $this->render('dashboard/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'app_edit_profile', methods: ['GET', 'POST'])]
    public function editProfile(
        #[MapEntity(expr: 'repository.findWithDiplomes(id)')] User $user,
    ): Response
    {
        return $this->render('dashboard/profile_edit.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/', name: 'app_landing', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/landing.html.twig');
    }
}
