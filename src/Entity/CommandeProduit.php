<?php

namespace App\Entity;

use App\Entity\Commande;
use App\Entity\ParfumVariant;
use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\ManyToOne]
    private ?ParfumVariant $parfumVariant = null;

    #[ORM\ManyToOne(inversedBy: 'commandeProduits')]
    private ?Commande $commande = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getParfumVariant(): ?ParfumVariant
    {
        return $this->parfumVariant;
    }

    public function setParfumVariant(?ParfumVariant $parfumVariant): static
    {
        $this->parfumVariant = $parfumVariant;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;

        return $this;
    }
}