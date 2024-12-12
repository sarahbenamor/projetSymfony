<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use App\Repository\VehiculeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface ;
use Symfony\Component\Mime\Email; 

class VehiculeController extends AbstractController
{
    private $vehiculeRepository;
    private $entityManager;

    public function __construct(VehiculeRepository $vehiculeRepository, EntityManagerInterface $entityManager)
    {
        $this->vehiculeRepository = $vehiculeRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/vehicule', name: 'vehicule_home')]
    public function index(): Response
    {
        $vehicules = $this->vehiculeRepository->findAll();
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }
    #[Route('/vehicule/list', name:'vehicule_list')]
    public function list(): Response { $vehicules = $this->getDoctrine()->getRepository(Vehicule::class)->findAll(); return $this->render('table.html.twig', [ 'items' => $vehicules, ]); }

    #[Route('/vehicule/new', name: 'vehicule_new')]
    public function new(Request $request): Response
    {
        $vehicule = new Vehicule();
        $form = $this->createForm(VehiculeType::class, $vehicule);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($vehicule);
            $this->entityManager->flush();

            return $this->redirectToRoute('vehicule_home');
        }

        return $this->render('vehicule/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/vehicule/edit/{id}', name: 'vehicule_edit')]
    public function edit(Request $request, Vehicule $vehicule): Response
    {
        $form = $this->createForm(VehiculeType::class, $vehicule);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('vehicule_home');
        }

        return $this->render('vehicule/edit.html.twig', [
            'form' => $form->createView(),
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/vehicule/delete/{id}', name: 'vehicule_delete')]
    public function delete(Request $request, Vehicule $vehicule): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vehicule->getId(), $request->request->get('_token'))) {
            $this->entityManager->remove($vehicule);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('vehicule_home');
    }
    #[Route('/vehicule/positions', name: 'get_positions')]
    public function getVehicles(): JsonResponse
    {
        $vehicles = [
            ['id' => 1, 'name' => 'Ariana', 'lat' => 36.8665, 'lng' => 10.1647],
            ['id' => 2, 'name' => 'Ghazela', 'lat' => 36.8951, 'lng' => 10.1885],
            ['id' => 3, 'name' => 'Raoued', 'lat' => 36.9488, 'lng' => 10.1983],
            ['id' => 3, 'name' => 'Ariana soghra', 'lat' => 36.9007, 'lng' => 10.1857],
        ];
        return new JsonResponse($vehicles);
    }

    #[Route('/vehicule/notification', name: 'notification_email')]
    public function notifyDelay(MailerInterface $mailer): Response
    {
        // Simple test data - replace with actual vehicle data and delay condition
        $recipient = 'user@example.com'; // User's email
        $ligne = 'Vehicle 1';
        $originalTime = new \DateTime('2024-12-11 14:00:00'); // Original departure time
        $newTime = new \DateTime('2024-12-11 15:00:00'); // New expected time

        $email = (new Email())
            ->from('no-reply@yourdomain.com')
            ->to($recipient)
            ->subject('Vehicle Delay Notification')
            ->html("<h1>Vehicle Journey Delay</h1>
                    <p>We would like to inform you that the vehicle <strong>{$ligne}</strong> is delayed.</p>
                    <p>Original Departure Time: {$originalTime->format('Y-m-d H:i:s')}</p>
                    <p>New Arrival Time: {$newTime->format('Y-m-d H:i:s')}</p>");

        // Send the email
        $mailer->send($email);

        return new Response('Delay notification sent successfully!');
    }
}
