<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
/*use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;*/

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8",minMessage="Votre mot de passe doit faire minimum 8 caractère")
     @Assert\EqualTo(propertyPath="confirm_password",message="vous devez taper le même mot de passe")
     */
    private $password;
    
    /**
     *@Assert\EqualTo(propertyPath="password",message="vous devez taper le même mot de passe")
     */
    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberPhone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberReservation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numberMissedAppointment;

    /**
     * @ORM\OneToMany(targetEntity=Modification::class, mappedBy="user")
     */
    private $modifications;

    public function __construct()
    {
        $this->modifications = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getNumberPhone(): ?string
    {
        return $this->numberPhone;
    }

    public function setNumberPhone(string $numberPhone): self
    {
        $this->numberPhone = $numberPhone;

        return $this;
    }

    public function getNumberReservation(): ?string
    {
        return $this->numberReservation;
    }

    public function setNumberReservation(string $numberReservation): self
    {
        $this->numberReservation = $numberReservation;

        return $this;
    }

    public function getNumberMissedAppointment(): ?string
    {
        return $this->numberMissedAppointment;
    }

    public function setNumberMissedAppointment(string $numberMissedAppointment): self
    {
        $this->numberMissedAppointment = $numberMissedAppointment;

        return $this;
    }

    public function eraseCredentials(){}

    public function getSalt(){

    }

    public function getRoles(){
        return ['ROLES_USER'];
    }

    /**
     * @return Collection|Modification[]
     */
    public function getModifications(): Collection
    {
        return $this->modifications;
    }

    public function addModification(Modification $modification): self
    {
        if (!$this->modifications->contains($modification)) {
            $this->modifications[] = $modification;
            $modification->setUser($this);
        }

        return $this;
    }

    public function removeModification(Modification $modification): self
    {
        if ($this->modifications->contains($modification)) {
            $this->modifications->removeElement($modification);
            // set the owning side to null (unless already changed)
            if ($modification->getUser() === $this) {
                $modification->setUser(null);
            }
        }

        return $this;
    }
}
