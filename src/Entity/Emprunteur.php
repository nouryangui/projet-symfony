<?php

namespace App\Entity;

use App\Repository\EmprunteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmprunteurRepository::class)
 */
class Emprunteur
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity=Emprunter::class, mappedBy="emprunteur")
     */
    private $emprunt;

    public function __construct()
    {
        $this->emprunt = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Emprunter[]
     */
    public function getEmprunt(): Collection
    {
        return $this->emprunt;
    }

    public function addEmprunt(Emprunter $emprunt): self
    {
        if (!$this->emprunt->contains($emprunt)) {
            $this->emprunt[] = $emprunt;
            $emprunt->setEmprunteur($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunter $emprunt): self
    {
        if ($this->emprunt->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getEmprunteur() === $this) {
                $emprunt->setEmprunteur(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getUsername();
    }


}
