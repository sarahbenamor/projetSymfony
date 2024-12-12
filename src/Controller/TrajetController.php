<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Form\TrajetType;
use App\Form\TrajetSearchType;
use App\Repository\TrajetRepository;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Dompdf\Dompdf;
use Dompdf\Options;

class TrajetController extends AbstractController
{
    private $trajetRepository;
    private $entityManager;

    public function __construct(TrajetRepository $trajetRepository, EntityManagerInterface $entityManager)
    {
        $this->trajetRepository = $trajetRepository;
        $this->entityManager = $entityManager;
    }
    #[Route('/trajet', name: 'trajet_home')]
    public function index(Request $request, TrajetRepository $trajetRepository,VehiculeRepository $vehiculeRepository): Response
    {
        // Récupérer le paramètre 'ligne' de la requête
        $ligne = $request->query->get('ligne', '');
        $sort = $request->query->get('sort', 't.id'); // Par défaut, trier par ID
        $direction = $request->query->get('direction', 'asc'); // Direction par défaut : ascendant
    
        // Initialiser la requête pour récupérer les trajets
        $queryBuilder = $trajetRepository->createQueryBuilder('t');
        
        if (!empty($ligne)) {
            if (is_numeric($ligne)) {
                // Recherche stricte par ligne
                $queryBuilder->where('t.ligne = :ligne')
                             ->setParameter('ligne', $ligne);
            } else {
                // Recherche partielle (utilisation de LIKE)
                $queryBuilder->where('t.ligne LIKE :ligne')
                             ->orWhere('t.pointDepart LIKE :ligne')
                             ->orWhere('t.destination LIKE :ligne')
                             ->setParameter('ligne', '%' . $ligne . '%');
            }
        }
        $queryBuilder->orderBy($sort, $direction);
        // Exécuter la requête
        $trajets = $queryBuilder->getQuery()->getResult();

         // 1 Récupérer le véhicule le plus utilisé
         $vehiculePlusUtilise = $vehiculeRepository->findVehiculePlusUtilise();

         // 2️ Récupérer le trajet le plus demandé
         $trajetPlusDemande = $trajetRepository->findTrajetPlusDemande();
 
         // 3️ Changer le statut des véhicules ayant atteint leur capacité
         $vehiculeRepository->updateStatutVehiculeIndisponible();
    
        return $this->render('trajet/index.html.twig', [
            'trajets' => $trajets,
            'ligne' => $ligne,
            'sort' => $sort,
            'direction' => $direction ,
            'vehicule_plus_utilise' => $vehiculePlusUtilise,
            'trajet_plus_demande' => $trajetPlusDemande
        ]);
    }

    #[Route('/trajet/new', name: 'trajet_new')]
    public function new(Request $request): Response
    {
        $trajet = new Trajet();
        $form = $this->createForm(TrajetType::class, $trajet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($trajet);
            $this->entityManager->flush();

            return $this->redirectToRoute('trajet_home');
        }

        return $this->render('trajet/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/trajet/edit/{id}', name: 'trajet_edit')]
    public function edit(Request $request, Trajet $trajet): Response
    {
        $form = $this->createForm(TrajetType::class, $trajet);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('trajet_home');
        }

        return $this->render('trajet/edit.html.twig', [
            'form' => $form->createView(),
            'trajet' => $trajet,
        ]);
    }

    #[Route('/trajet/delete/{id}', name: 'trajet_delete')]
    public function delete(Request $request, Trajet $trajet): Response
    {
        if ($this->isCsrfTokenValid('delete' . $trajet->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($trajet);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('trajet_home');
    }
    #[Route('/trajet/pdf', name: 'trajet_pdf')]
public function exportPdf(TrajetRepository $trajetRepository): Response
{
    $trajets = $trajetRepository->findAll();

    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Arial'); 

    $dompdf = new Dompdf($pdfOptions);

    $html = $this->renderView('trajet/pdf.html.twig', [
        'trajets' => $trajets
    ]);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    return new Response($dompdf->stream('liste_trajets.pdf', [
        'Attachment' => true
    ]));
}


//     #[Route('/trajet/search', name: 'trajet_search')]
// public function search(Request $request, TrajetRepository $trajetRepository): Response
// {
//     // Récupération des données du formulaire
//     $form = $this->createFormBuilder()
//         ->add('ligne', TextType::class, [
//             'required' => false,
//             'attr' => ['placeholder' => 'Rechercher par ligne']
//         ])
//         ->getForm();

//     $form->handleRequest($request);
//     $trajets = [];

//     if ($form->isSubmitted() && $form->isValid()) {
//         $searchData = $form->getData();
        
//         if (!empty($searchData['ligne'])) {
//             // Recherche de la ligne dans la base de données
//             $trajets = $trajetRepository->findBy(['ligne' => $searchData['ligne']]);
//         }
//     }

//     return $this->render('trajet/search.html.twig', [
//         'form' => $form->createView(),
//         'trajets' => $trajets
//     ]);
// }


    
}

