<?php

namespace App\Controller;

use App\Repository\TrajetRepository;
use App\Repository\VehiculeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'app_utilisateur')]
    public function index(TrajetRepository $trajetRepository, VehiculeRepository $vehiculeRepository)
    {
        $trajets = $trajetRepository->findAll();
        $vehicules = $vehiculeRepository->findAll();

        return $this->render('utilisateur.html.twig', [
            'trajets' => $trajets,
            'vehicules' => $vehicules,
        ]);
    }
    
}


