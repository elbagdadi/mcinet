<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EstimationRepository")
 */
class Estimation
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
    private $secteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_estimation;

    /**
     * @ORM\Column(type="integer")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $ecosystem;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSecteur(): ?string
    {
        return $this->secteur;
    }

    public function setSecteur(string $secteur): self
    {
        $this->secteur = $secteur;

        return $this;
    }

    public function getDateEstimation(): ?string
    {
        return $this->date_estimation;
    }

    public function setDateEstimation(string $date_estimation): self
    {
        $this->date_estimation = $date_estimation;

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getEcosystem(): ?int
    {
        return $this->ecosystem;
    }

    public function setEcosystem(int $ecosystem): self
    {
        $this->ecosystem = $ecosystem;

        return $this;
    }
}
