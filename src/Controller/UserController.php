<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'user.index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user.new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('user.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'user.show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[IsGranted('ROLE_CANDIDAT')]
    #[Route('/{id}/candidat_edit', name: 'user.cand_edit', methods: ['GET', 'POST'])]
    public function cand_edit(
        Request $request, 
        EntityManagerInterface $manager,
        User $user, 
        UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été modifié avec succès !'
            );
            return $this->redirectToRoute('job.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/cand_edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_RECRUITER')]
    #[Route('/{id}/recruiter_edit', name: 'user.recr_edit', methods: ['GET', 'POST'])]
    public function recr_edit(
        Request $request, 
        EntityManagerInterface $manager,
        User $user, 
        UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été modifié avec succès !'
            );
            return $this->redirectToRoute('job.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/recr_edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}', 'user.delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(
        EntityManagerInterface $manager,
        User $user
    ): Response {
       
        $manager->remove($user);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre user a été supprimé avec succès !'
        );

        return $this->redirectToRoute('user.index');
    }
}
