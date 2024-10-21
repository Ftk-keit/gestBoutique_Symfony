<?php

namespace App\Entity;

use App\enum\StatusDette;
use App\Repository\DetteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetteRepository::class)]
class Dette
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $data = null;

    #[ORM\Column]
    private ?int $montant = null;

    #[ORM\Column]
    private ?int $montanVerser = null;

    #[ORM\ManyToOne(inversedBy: 'dettes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    private StatusDette $status = StatusDette::Impayé;
    

    public function __construct() {
       
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): ?\DateTimeInterface
    {
        return $this->data;
    }

    public function setData(\DateTimeInterface $data): static
    {
        $this->data = $data;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setStatus(StatusDette $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): ?StatusDette
    {
        if ( $this->montanVerser != 0 && $this->montant === $this->montanVerser) { 
            $this->status = StatusDette::Payé;
        }
        return $this->status;
    }

    public function setMontant(int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMontantVerser(): ?int
    {
        return $this->montanVerser;
    }

    public function setMontantVerser(int $montanVerser): static
    {
        $this->montanVerser = $montanVerser;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
