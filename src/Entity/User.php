<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ORM\EntityListeners(['App\EntityListener\UserListener'])]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastname = null;


    #[ORM\Column]
    private array $roles = [];

    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    // #[Assert\NotBlank()]
    private ?string $password = 'password';

    #[ORM\Column]
    private? bool $isVerified = false;

    #[ORM\ManyToMany(targetEntity: Job::class)]
    private Collection $jobs;

    #[ORM\OneToOne(targetEntity: Candidat::class, cascade: ['persist', 'remove'])]
    private ?Candidat $candidat = null;

    #[ORM\OneToOne(targetEntity: Recruiter::class, cascade: ['persist', 'remove'])]
    private ?Recruiter $recruiter = null;

    #[ORM\OneToOne(targetEntity: Consultant::class, cascade: ['persist', 'remove'])]
    private ?Consultant $consultant = null;

    
    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Company $company = null;

    

    public function __construct()
    {
        $this->jobs = new ArrayCollection();
    
       
       
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
      

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->lastname;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

      /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }



    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
    public function __toString()
    {
        return $this->lastname;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(Candidat $candidat): self
    {
        // set the owning side of the relation if necessary
        if ($candidat->getUser() !== $this) {
            $candidat->setUser($this);
        }

        $this->candidat = $candidat;

        return $this;
    }

    public function getRecruiter(): ?Recruiter
    {
        return $this->recruiter;
    }

    public function setRecruiter(Recruiter $recruiter): self
    {
        // set the owning side of the relation if necessary
        if ($recruiter->getUser() !== $this) {
            $recruiter->setUser($this);
        }

        $this->recruiter = $recruiter;

        return $this;
    }

    public function getConsultant(): ?Consultant
    {
        return $this->consultant;
    }

    public function setConsultant(Consultant $consultant): self
    {
        // set the owning side of the relation if necessary
        if ($consultant->getUsers() !== $this) {
            $consultant->setUsers($this);
        }

        $this->consultant = $consultant;

        return $this;
    }

    // /**
    //  * @return Collection<int, Annonce>
    //  */
    // public function getAnnonces(): Collection
    // {
    //     return $this->annonces;
    // }

    // public function addAnnonce(Annonce $annonce): self
    // {
    //     if (!$this->annonces->contains($annonce)) {
    //         $this->annonces->add($annonce);
    //         $annonce->setAuthor($this);
    //     }

    //     return $this;
    // }

    // public function removeAnnonce(Annonce $annonce): self
    // {
    //     if ($this->annonces->removeElement($annonce)) {
    //         // set the owning side to null (unless already changed)
    //         if ($annonce->getAuthor() === $this) {
    //             $annonce->setAuthor(null);
    //         }
    //     }

    //     return $this;
    // }
     /**
     * Get the value of Company
     */ 
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the value of Company
     *
     * @return  self
     */ 
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    
}
