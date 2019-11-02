<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HasFieldRepository")
 */
class HasField
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
    private $field_label;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $field_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $true_value;

    /**
     * @ORM\Column(type="text")
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Secteur", inversedBy="hasFields")
     */
    private $secteur;

    /**
     * @ORM\Column(type="string",length=255, nullable=true)
     */
    private $selector_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selector_classes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $selector_placeholder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldLabel(): ?string
    {
        return $this->field_label;
    }

    public function setFieldLabel(string $field_label): self
    {
        $this->field_label = $field_label;

        return $this;
    }

    public function getFieldType(): ?string
    {
        return $this->field_type;
    }

    public function setFieldType(string $field_type): self
    {
        $this->field_type = $field_type;

        return $this;
    }

    public function getTrueValue(): ?string
    {
        return $this->true_value;
    }

    public function setTrueValue(string $true_value): self
    {
        $this->true_value = $true_value;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(string $options): self
    {
        $this->options = $options;

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

    public function getSelectorId(): ?string
    {
        return $this->selector_id;
    }

    public function setSelectorId(?string $selector_id): self
    {
        $this->selector_id = $selector_id;

        return $this;
    }

    public function getSelectorClasses(): ?string
    {
        return $this->selector_classes;
    }

    public function setSelectorClasses(?string $selector_classes): self
    {
        $this->selector_classes = $selector_classes;

        return $this;
    }

    public function getSelectorPlaceholder(): ?string
    {
        return $this->selector_placeholder;
    }

    public function setSelectorPlaceholder(?string $selector_placeholder): self
    {
        $this->selector_placeholder = $selector_placeholder;

        return $this;
    }
}
