<?php

namespace App\Entity;

use App\Repository\OperationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OperationRepository::class)]
class Operation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOperation = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantDebit = null;

    #[ORM\Column(nullable: true)]
    private ?int $montantCredit = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleOperation = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vente $vente = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Compte $compte = null;

    #[ORM\ManyToOne(inversedBy: 'operations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Depense $depense = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOperation(): ?\DateTimeInterface
    {
        return $this->dateOperation;
    }

    public function setDateOperation(\DateTimeInterface $dateOperation): static
    {
        $this->dateOperation = $dateOperation;

        return $this;
    }

    public function getMontantDebit(): ?int
    {
        return $this->montantDebit;
    }

    public function setMontantDebit(?int $montantDebit): static
    {
        $this->montantDebit = $montantDebit;

        return $this;
    }

    public function getMontantCredit(): ?int
    {
        return $this->montantCredit;
    }

    public function setMontantCredit(?int $montantCredit): static
    {
        $this->montantCredit = $montantCredit;

        return $this;
    }

    public function getLibelleOperation(): ?string
    {
        return $this->libelleOperation;
    }

    public function setLibelleOperation(string $libelleOperation): static
    {
        $this->libelleOperation = $libelleOperation;

        return $this;
    }

    public function getVente(): ?Vente
    {
        return $this->vente;
    }

    public function setVente(?Vente $vente): static
    {
        $this->vente = $vente;

        return $this;
    }

    public function getCompte(): ?Compte
    {
        return $this->compte;
    }

    public function setCompte(?Compte $compte): static
    {
        $this->compte = $compte;

        return $this;
    }

    public function getDepense(): ?Depense
    {
        return $this->depense;
    }

    public function setDepense(?Depense $depense): static
    {
        $this->depense = $depense;

        return $this;
    }

    public function __toString(){
        return $this->libelleOperation;
    }
}