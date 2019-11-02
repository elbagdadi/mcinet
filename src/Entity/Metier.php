<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MetierRepository")
 */
class Metier
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
    private $nom_metier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug_metier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secteur", inversedBy="metiers")
     */
    private $secteur;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ecosystem", inversedBy="metiers")
     */
    private $ecosystem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMetier(): ?string
    {
        return $this->nom_metier;
    }

    public function setNomMetier(string $nom_metier): self
    {
        $this->nom_metier = $nom_metier;

        return $this;
    }

    public function getSlugMetier(): ?string
    {
        return $this->slug_metier;
    }

    public function setSlugMetier(string $slug_metier): self
    {
        $this->slug_metier = $slug_metier;

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

    public function getEcosystem(): ?Ecosystem
    {
        return $this->ecosystem;
    }

    public function setEcosystem(?Ecosystem $ecosystem): self
    {
        $this->ecosystem = $ecosystem;

        return $this;
    }
}
