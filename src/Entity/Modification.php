<?php

namespace App\Entity;

use App\Repository\ModificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ModificationRepository::class)
 */
class Modification
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_modification;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="modifications")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Setting::class, inversedBy="modifications")
     */
    private $parametre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateModification(): ?\DateTimeInterface
    {
        return $this->date_modification;
    }

    public function setDateModification(\DateTimeInterface $date_modification): self
    {
        $this->date_modification = $date_modification;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getParametre(): ?Setting
    {
        return $this->parametre;
    }

    public function setParametre(?Setting $parametre): self
    {
        $this->parametre = $parametre;

        return $this;
    }
}
