<?php

namespace App\Entity;

use App\Repository\RecruiterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

#[ORM\Entity(repositoryClass: RecruiterRepository::class)]
class Recruiter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'recruiter', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'recruiters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $Company = null;

   
    public function getId(): ?int
    {
        return $this->id;
    }

  /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
    /**
     * Get the value of Company
     */ 
    public function getCompany()
    {
        return $this->Company;
    }

    /**
     * Set the value of Company
     *
     * @return  self
     */ 
    public function setCompany($Company)
    {
        $this->Company = $Company;

        return $this;
    }
    

  
}
