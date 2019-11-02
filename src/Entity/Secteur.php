<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SecteurRepository")
 */
class Secteur
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
    private $nom_secteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug_secteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secteur", inversedBy="secteurs")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Secteur", mappedBy="parent")
     */
    private $secteurs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $federation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Metier", mappedBy="secteur")
     */
    private $metiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ecosystem", mappedBy="secteur")
     */
    private $ecosystems;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasField", mappedBy="secteur")
     */
    private $hasFields;

    public function __construct()
    {
        $this->secteurs = new ArrayCollection();
        $this->metiers = new ArrayCollection();
        $this->ecosystems = new ArrayCollection();
        $this->hasFields = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSecteur(): ?string
    {
        return $this->nom_secteur;
    }

    public function setNomSecteur(string $nom_secteur): self
    {
        $this->nom_secteur = $nom_secteur;

        return $this;
    }

    public function getSlugSecteur(): ?string
    {
        return $this->slug_secteur;
    }

    public function setSlugSecteur(string $slug_secteur): self
    {
        $this->slug_secteur = $slug_secteur;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getSecteurs(): Collection
    {
        return $this->secteurs;
    }

    public function addSecteur(self $secteur): self
    {
        if (!$this->secteurs->contains($secteur)) {
            $this->secteurs[] = $secteur;
            $secteur->setParent($this);
        }

        return $this;
    }

    public function removeSecteur(self $secteur): self
    {
        if ($this->secteurs->contains($secteur)) {
            $this->secteurs->removeElement($secteur);
            // set the owning side to null (unless already changed)
            if ($secteur->getParent() === $this) {
                $secteur->setParent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {

            return $this->getNomSecteur();



    }

    public function getFederation(): ?string
    {
        return $this->federation;
    }

    public function setFederation(string $federation): self
    {
        $this->federation = $federation;

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
            $metier->setSecteur($this);
        }

        return $this;
    }

    public function removeMetier(Metier $metier): self
    {
        if ($this->metiers->contains($metier)) {
            $this->metiers->removeElement($metier);
            // set the owning side to null (unless already changed)
            if ($metier->getSecteur() === $this) {
                $metier->setSecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ecosystem[]
     */
    public function getEcosystems(): Collection
    {
        return $this->ecosystems;
    }

    public function addEcosystem(Ecosystem $ecosystem): self
    {
        if (!$this->ecosystems->contains($ecosystem)) {
            $this->ecosystems[] = $ecosystem;
            $ecosystem->setSecteur($this);
        }

        return $this;
    }

    public function removeEcosystem(Ecosystem $ecosystem): self
    {
        if ($this->ecosystems->contains($ecosystem)) {
            $this->ecosystems->removeElement($ecosystem);
            // set the owning side to null (unless already changed)
            if ($ecosystem->getSecteur() === $this) {
                $ecosystem->setSecteur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HasField[]
     */
    public function getHasFields(): Collection
    {
        return $this->hasFields;
    }

    public function addHasField(HasField $hasField): self
    {
        if (!$this->hasFields->contains($hasField)) {
            $this->hasFields[] = $hasField;
            $hasField->setSecteur($this);
        }

        return $this;
    }

    public function removeHasField(HasField $hasField): self
    {
        if ($this->hasFields->contains($hasField)) {
            $this->hasFields->removeElement($hasField);
            // set the owning side to null (unless already changed)
            if ($hasField->getSecteur() === $this) {
                $hasField->setSecteur(null);
            }
        }

        return $this;
    }

}
