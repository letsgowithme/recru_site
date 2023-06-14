<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\Email;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    /**
     * @var MailerInterface
     */
   

    public function __construct(private MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(): Response
    {
            $email = (new Email())
            ->from('recru_no_reply@recru.com')
            ->to('admin@exemple.com')
            ->subject('Info de candidat')
            ->htmlTemplate('<p>C\'est une information</p>');
            

        $this->mailer->send($email);
    
} }
