<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use App\Entity\Job;
use App\Entity\Recruiter;
use App\Entity\User;
use App\Repository\JobRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }
    
 #[IsGranted('ROLE_ADMIN')]
 #[Route('/job', name: 'job.edit', methods: ['GET'])]
 public function editJob(JobRepository $jobRepository): Response
 {
    return $this->render('job/edit.html.twig');
    
 }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToRoute('Voir le site', 'fas fa-list', 'home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Candidats', 'fas fa-user', Candidat::class);
        yield MenuItem::linkToCrud('Recruteurs', 'fas fa-user', Recruiter::class);
        // yield MenuItem::linkToCrud('Demandes d\'inscription', 'fas fa-envelope', Contact::class);
        // yield MenuItem::linkToCrud('Comments', 'fas fa-envelope', Comment::class);
        yield MenuItem::linkToCrud('Annonces', 'fas fa-seedling', Job::class);
    }
   
}
