<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vehicule;
use App\Entity\Trajet;

class ItemController extends AbstractController
{
    
    #[Route('/items', name: 'item_list')]
    public function list(): Response
    {
        $vehicule = $this->getDoctrine()->getRepository(Vehicule::class)->findAll();
        $trajets = $this->getDoctrine()->getRepository(Trajet::class)->findAll();

        return $this->render('table.html.twig', [
            'vehicules' => $vehicule,
            'trajets' => $trajets,
        ]);
    }
}
?>
