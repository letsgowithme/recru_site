<?php

namespace App\Controller;

use App\Entity\Apply;
// use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ApplyRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Notifier\Recipient\Recipient;
use Symfony\Component\Routing\Annotation\Route;


class ApplyController extends AbstractController
{
    #[Route('/apply', name: 'app_apply')]
    public function index(ApplyRepository $applyRepository,
    // $id,
    Apply $apply,
    NotifierInterface $notifier,
    ): Response
    {
       
        $applies = $applyRepository->findBy(['isApproved' => true]);
        
        $emailRecru = $apply->getJob()->getAuthor()->getEmail();
        if($applies) {
            $notification = (new Notification('Nouveau cnadidat', ['email']))
            ->content('Vous avez un canddat postulé pour votre annonce');

             // The receiver of the Notification
        $recipient = new Recipient(
            $emailRecru
            
        );

        // Send the notification to the recipient
        $notifier->send($notification, $recipient);

        }
       
             
        return $this->render('apply/index.html.twig', [
            'applies' => $applies,
            
        ]);
    }
}
