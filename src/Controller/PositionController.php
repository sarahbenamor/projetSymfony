<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PositionController extends AbstractController
{
    // #[Route('/vehicule/positions', name: 'get_positions')]

    // public function getPositions(): JsonResponse
    // {
    //     $positions = [
    //         ['id' => 1, 'latitude' => 36.8065, 'longitude' => 10.1815],
    //         ['id' => 2, 'latitude' => 36.8150, 'longitude' => 10.1800],
    //         ['id' => 3, 'latitude' => 36.8120, 'longitude' => 10.1700],
    //     ];

    //     return new JsonResponse($positions);
    // }

    #[Route('/vehicule/map', name: 'vehicule_map')]
    public function map(): Response
{
    $googleMapsApiKey = 'AIzaSyC06ky_8t7h7kTrhIdUBwXC9vCnsvXlX7E';
    return $this->render('vehicule/map.html.twig', [
        'google_maps_api_key' => $googleMapsApiKey,
    ]);;
}
}
