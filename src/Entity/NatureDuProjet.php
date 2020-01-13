<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NatureDuProjetRepository")
 */
class NatureDuProjet
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Metier", mappedBy="natureDuProjet")
     */
    private $metiers;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|metier[]
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(metier $metier): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers[] = $metier;
            $metier->setNatureDuProjet($this);
        }

        return $this;
    }

    public function removeMetier(metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getNatureDuProjet() === $this) {
                $metier->setNatureDuProjet(null);
            }
        }

        return $this;
    }
}
