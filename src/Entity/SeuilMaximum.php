<?php

namespace App\Entity;

use App\Repository\SeuilMaximumRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeuilMaximumRepository::class)]
class SeuilMaximum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $seuilmaximum = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeuilmaximum(): ?int
    {
        return $this->seuilmaximum;
    }

    public function setSeuilmaximum(int $seuilmaximum): self
    {
        $this->seuilmaximum = $seuilmaximum;

        return $this;
    }
}
