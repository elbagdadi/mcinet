<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EcosystemRepository")
 */
class Ecosystem
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
    private $nom_ecosystem;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug_ecosystem;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secteur", inversedBy="ecosystems")
     */
    private $secteur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Metier", mappedBy="ecosystem")
     */
    private $metiers;

    /**
     * @ORM\Column(type="integer")
     */
    private $sorting;

    public function __construct()
    {
        $this->metiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEcosystem(): ?string
    {
        return $this->nom_ecosystem;
    }

    public function setNomEcosystem(string $nom_ecosystem): self
    {
        $this->nom_ecosystem = $nom_ecosystem;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomEcosystem();
    }

    public function getSlugEcosystem(): ?string
    {
        return $this->slug_ecosystem;
    }

    public function setSlugEcosystem(string $slug_ecosystem): self
    {
        $this->slug_ecosystem = $slug_ecosystem;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSorting(): ?int
    {
        return $this->sorting;
    }

    /**
     * @param mixed $sorting
     */
    public function setSorting($sorting): self
    {
        $this->sorting = $sorting;
        return $this;
    }

    public function getSecteur(): ?Secteur
    {
        return $this->secteur;
    }

    public function setSecteur(?Secteur $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    /**
     * @return Collection|Metier[]
     */
    public function getMetiers(): Collection
    {
        return $this->metiers;
    }

    public function addMetier(Metier $metier): self
    {
        if (!$this->metiers->contains($metier)) {
            $this->metiers[] = $metier;
            $metier->setEcosystem($this);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getEcosystem() === $this) {
                $metier->setEcosystem(null);
            }
        }

        return $this;
    }

}
