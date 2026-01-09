<?php

namespace App\Controller;

use App\Entity\Sejour;
use App\Repository\SejourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/sejour')]
final class SejourController extends AbstractController
{
    #[Route('/', name: 'app_sejours', methods: ['GET'])]    
    public function index(
        SejourRepository $sejourRepository,
    ): Response
    {
        $sejours = $sejourRepository->findAllWithResume();
        return $this->render('sejour/index.html.twig', [
            'sejours' => $sejours,
        ]);
    }

    #[Route('/{sejour}/dashboard', name: 'app_sejour_show', methods: ['GET'])]
    public function details(
        Sejour $sejour,
    ): Response
    {
        return $this->render('sejour/details.html.twig', [
            'sejour' => $sejour,
        ]);
    }
}
