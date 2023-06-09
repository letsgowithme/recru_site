<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
#[Route('/contact', name: 'contact.index')]
public function index(
Request $request,
EntityManagerInterface $manager,
MailService $mailService
): Response
{
$contact = new Contact();

if($this->getUser()) {
$contact->setLastname($this->getUser()->getLastname())
        ->setEmail($this->getUser()->getEmail());
}

$form = $this->createForm(ContactType::class, $contact);

$form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) {

$contact = $form->getData();
$manager->persist($contact);
$manager->flush();

//Email
$mailService->sendEmail(
$contact->getEmail(),
$contact->getSubject(),
'emails/contact.html.twig',
['contact' => $contact],
$contact->setEmail($this->getUser()->getRecruiter()->getEmail()),
);

$this->addFlash(
'success',
'Votre message a été envoyé avec succès !'
);
return $this->redirectToRoute('home');
}

return $this->render('emails/contact.html.twig', [
'form' => $form->createView(),
// 'contact' => $contact

]);
}
}


