<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Parfum>
     */
    #[ORM\ManyToMany(targetEntity: Parfum::class, mappedBy: 'families')]
    private Collection $parfums;

    public function __construct()
    {
        $this->parfums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $parfum->addFamily($this);
        }

        return $this;
    }

    public function removeParfum(Parfum $parfum): static
    {
        if ($this->parfums->removeElement($parfum)) {
            $parfum->removeFamily($this);
        }

        return $this;
    }
}
