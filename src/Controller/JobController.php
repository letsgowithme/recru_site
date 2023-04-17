<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/job')]
class JobController extends AbstractController
{
    /**
     * Show all the recipes for everybody
     * @param JobRepository $jobRepository
     * @return Response
     */
    #[Route('/', name: 'job.all', methods: ['GET'])]
    public function index(JobRepository $jobRepository): Response
    {
        return $this->render('job/all.html.twig', [
            'jobs' => $jobRepository->findAll(),
        ]);
    }
     /**
     * Show the jobs if user is connected
     * @param JobRepository $jobRepository
     * @return Response
     */
   
    #[Route('/index', name: 'job.index', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function all(JobRepository $repository): Response
    {
        $jobs = $repository->findAll();
        return $this->render('job/index.html.twig', [
            'jobs' => $jobs,
        ]);
    }
      /**
     * Show the jobs if user is connected
     * @param JobRepository $repository
     * @return Response
     */
   
     #[Route('/index', name: 'job.index', methods: ['GET'])]
     #[IsGranted('ROLE_RECRUITER')]
     public function annonces(JobRepository $repository): Response
     {
       $jobs =  $repository->findBy(['author' => $this->getUser()]);

         return $this->render('job/index.html.twig', [
             'jobs' => $jobs,
             'author' => $this->getUser(),
         ]);
     }
    
 /**
     * This function creates a job
     * @param Job $job
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[IsGranted('ROLE_RECRUITER')]
    #[Route('/new', name: 'job.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $job = new Job();
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $jobRepository->save($job, true);
            $job = $form->getData();
            $job->setAuthor($this->getUser());

            $manager->persist($job);
            $manager->flush();


            return $this->redirectToRoute('job.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job/new.html.twig', [
            'job' => $job,
            // 'job_annonce' => $job_annonce,
            'form' => $form->createView(),
            
        ]);
    }
/**
     * Show the job detail of a user
     * @param Job $job
     * @param Request $request
     * @return Response
     */
    #[Route('/{id}', name: 'job.show', methods: ['GET'])]
    public function show(Job $job): Response
    {
        return $this->render('job/show.html.twig', [
            'job' => $job,
        ]);
    }

     /**
     * This function edits the job
     * @param Job $job
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_RECRUITER')]
    #[Route('/{id}/edit', name: 'job.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Job $job, JobRepository $jobRepository): Response
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $jobRepository->save($job, true);

            return $this->redirectToRoute('job.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job/edit.html.twig', [
            'job' => $job,
            'form' => $form,
        ]);
    }

     /**
     * This function deletes the job
     * @param Job $job
     * @param Request $request
     * @return Response
     */
    #[IsGranted('ROLE_RECRUITER')]
    #[Route('/{id}', name: 'job.delete', methods: ['POST'])]
    public function delete(Request $request, Job $job, JobRepository $jobRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$job->getId(), $request->request->get('_token'))) {
            $jobRepository->remove($job, true);
        }

        return $this->redirectToRoute('job.index', [], Response::HTTP_SEE_OTHER);
    }
}
