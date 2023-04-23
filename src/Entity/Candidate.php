<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'candidate', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: Job::class)]
    private Collection $jobs;

 

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

     /**
     * Get the value of jobs
     */ 
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set the value of jobs
     *
     * @return  self
     */ 
    public function setJobs($jobs)
    {
        $this->jobs = $jobs;

        return $this;
    }
 
    // public function __toString()
    // {
    //     return $this->lastname;
        
    // }
}
