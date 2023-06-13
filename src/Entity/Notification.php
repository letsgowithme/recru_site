<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // #[ORM\ManyToOne(inversedBy: 'notifications')]
    // #[ORM\JoinColumn(onDelete: 'CASCADE')]
    // private ?Apply $apply = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getApply(): ?Apply
    // {
    //     return $this->apply;
    // }

    // public function setApply(?Apply $apply): self
    // {
    //     $this->apply = $apply;

    //     return $this;
    // }
}
