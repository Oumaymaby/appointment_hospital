<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CreneauRepository::class)
 */
class Creneau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    /**
     * @ORM\Column(type="time")
     */
    private $debut_duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat_creneau;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDebutDuree(): ?\DateTimeInterface
    {
        return $this->debut_duree;
    }

    public function setDebutDuree(\DateTimeInterface $debut_duree): self
    {
        $this->debut_duree = $debut_duree;

        return $this;
    }

    public function getEtatCreneau(): ?string
    {
        return $this->etat_creneau;
    }

    public function setEtatCreneau(string $etat_creneau): self
    {
        $this->etat_creneau = $etat_creneau;

        return $this;
    }

    
}
