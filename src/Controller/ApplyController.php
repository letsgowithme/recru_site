<?php

namespace App\Controller;

use App\Entity\Apply;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ApplyRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    #[Route('/apply', name: 'app_apply')]
    public function index(ApplyRepository $applyRepository,
    // $id,
    Apply $apply,
    MailerInterface $mailer
    ): Response
    {
       
        $applies = $applyRepository->findBy(['isApproved' => true]);
        
        $emailRecru = $apply->getJob()->getAuthor()->getEmail();
        if($applies) {
            $email = (new TemplatedEmail())
            ->from('no_reply_recru@recru.fr')
            ->to($emailRecru)
            ->subject(($apply->getCandidate()->getFirstname()))
            ->html(($apply->getCandidate()->getCvFilename()));

        $mailer->send($email);
        }
       
             
        return $this->render('apply/index.html.twig', [
            'applies' => $applies,
            
        ]);
    }
}
