<?php
namespace App\Controller;

use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RetardController extends AbstractController
{
   
    #[Route('/trajet/check-retards', name: 'check_retards')]
     public function checkRetards(TrajetRepository $trajetRepository, MailerInterface $mailer): JsonResponse
    {
        $trajets = $trajetRepository->findAll(); 
        $now = new \DateTime(); 
        $emailsSent = 0;

        foreach ($trajets as $trajet) {
            if ($trajet->getHoraire() && $trajet->getHoraire() < $now) {
                $email = (new Email())
                    ->from('sarah.benamor@tonsite.com')
                    ->to('client@example.com') 
                    ->subject('Notification de retard pour le trajet')
                    ->text("Le trajet de la ligne {$trajet->getLigne()} est en retard. Départ prévu à : " . $trajet->getHoraire()->format('H:i:s'));

                $mailer->send($email);
                $emailsSent++;
            }
        }

        return new JsonResponse([
            'message' => "$emailsSent emails envoyés pour les trajets en retard."
        ]);
    }
}
