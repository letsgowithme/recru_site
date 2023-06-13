<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\NotificationType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function index(Request $request,
    EntityManagerInterface $manager,
    MailService $mailService
    // Notification $notification
    ): Response
{
    $notification = new Notification();

    if($this->getUser()) {
        $notification->setApply($this->getUser()->getApply()->getCandidate())
                     ->setEmail($this->getUser()->getApply()->getCandidate()->getEmail());
                
    }

    $formNotification = $this->createForm(NotificationType::class, $notification);

    $formNotification->handleRequest($request);
    if ($formNotification->isSubmitted() && $formNotification->isValid()) {

         $notification = $formNotification->getData();
         $manager->persist($notification);
         $manager->flush();

         //Email
         $mailService->sendEmail(

            $notification->getEmail(),
            $notification->getSubject(),
            'emails/notification.html.twig',
            ['notification' => $notification]
        );

        
         $this->addFlash(
            'success',
            'Votre message a été envoyé avec succès !'
        );

        return $this->redirectToRoute('contact.index');
    
    }

   
    return $this->render('pages/contact/index.html.twig', [
        'form' => $formNotification->createView(),

    ]);



}
}





   
        