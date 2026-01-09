<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfileType;
use App\Repository\DiplomeRepository;
use App\Service\AvatarUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Request;

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
        Request $request,
        DiplomeRepository $diplomeRepository,
        EntityManagerInterface $entityManager,
        AvatarUploader $uploader,
    ): Response
    {
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avatarFile = $form->get('avatar')->getData();
    
            if ($avatarFile) {
                $newFilename = $uploader->uploadAvatar($avatarFile, $user->getId(), $user->getAvatarPath());
                $user->setAvatarPath($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('dashboard/profile_edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'tous_les_diplomes' => $diplomeRepository->findAll(),
        ]);
    }

    #[Route('/', name: 'app_landing', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('dashboard/landing.html.twig');
    }
}
