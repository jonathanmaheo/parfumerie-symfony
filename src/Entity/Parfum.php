<?php

namespace App\Entity;

use App\Entity\Family;
use App\Entity\ParfumVariant;
use App\Entity\Brand;
use App\Repository\ParfumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParfumRepository::class)]
class Parfum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $picture = null;

    #[ORM\ManyToOne(inversedBy: 'parfums')]
    private ?Brand $brand = null;

    #[ORM\OneToMany(mappedBy: 'parfum', targetEntity: ParfumVariant::class, cascade: ['persist', 'remove'])]
    private Collection $variants;

    #[ORM\Column(nullable: true)]
    private ?int $sillage = null;

    #[ORM\Column(nullable: true)]
    private ?int $tenue = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noteTete = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noteCoeur = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $noteFond = null;

    /**
     * @var Collection<int, family>
     */
    #[ORM\ManyToMany(targetEntity: Family::class, inversedBy: 'parfums')]
    private Collection $families;

    public function __construct()
    {
        $this->variants = new ArrayCollection();
        $this->families = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;
        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return Collection<int, ParfumVariant>
     */
    public function getVariants(): Collection
    {
        return $this->variants;
    }

    public function addVariant(ParfumVariant $variant): static
    {
        if (!$this->variants->contains($variant)) {
            $this->variants->add($variant);
            $variant->setParfum($this);
        }

        return $this;
    }

    public function removeVariant(ParfumVariant $variant): static
    {
        if ($this->variants->removeElement($variant)) {
            if ($variant->getParfum() === $this) {
                $variant->setParfum(null);
            }
        }

        return $this;
    }

    public function getSillage(): ?int
    {
        return $this->sillage;
    }

    public function setSillage(?int $sillage): static
    {
        $this->sillage = $sillage;
        return $this;
    }

    public function getTenue(): ?int
    {
        return $this->tenue;
    }

    public function setTenue(?int $tenue): static
    {
        $this->tenue = $tenue;
        return $this;
    }

    public function getNoteTete(): ?string
    {
        return $this->noteTete;
    }

    public function setNoteTete(?string $noteTete): static
    {
        $this->noteTete = $noteTete;
        return $this;
    }

    public function getNoteCoeur(): ?string
    {
        return $this->noteCoeur;
    }

    public function setNoteCoeur(?string $noteCoeur): static
    {
        $this->noteCoeur = $noteCoeur;
        return $this;
    }

    public function getNoteFond(): ?string
    {
        return $this->noteFond;
    }

    public function setNoteFond(?string $noteFond): static
    {
        $this->noteFond = $noteFond;
        return $this;
    }

    /**
     * @return Collection<int, family>
     */
    public function getFamilies(): Collection
    {
        return $this->families;
    }

    public function addFamily(family $family): static
    {
        if (!$this->families->contains($family)) {
            $this->families->add($family);
        }

        return $this;
    }

    public function removeFamily(family $family): static
    {
        $this->families->removeElement($family);

        return $this;
    }
}
