<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'Cet marque existe déjà!')]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    /**
     * @var Collection<int, Parfum>
     */

    #[ORM\OneToMany(targetEntity: Parfum::class, mappedBy: 'brand')]
    private Collection $parfums;

    #[ORM\Column(length: 255,  nullable: true)]
    private ?string $picture = null;

    public function __construct()
    {
        $this->parfums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Parfum>
     */
    public function getParfums(): Collection
    {
        return $this->parfums;
    }

    public function addParfum(Parfum $parfum): static
    {
        if (!$this->parfums->contains($parfum)) {
            $this->parfums->add($parfum);
            $parfum->setBrand($this);
        }

        return $this;
    }

    public function removeParfum(Parfum $parfum): static
    {
        if ($this->parfums->removeElement($parfum)) {
            // set the owning side to null (unless already changed)
            if ($parfum->getBrand() === $this) {
                $parfum->setBrand(null);
            }
        }

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
}
