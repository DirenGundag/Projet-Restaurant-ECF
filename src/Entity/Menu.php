<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Formule::class)]
    private Collection $menu;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Formule>
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Formule $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu->add($menu);
            $menu->setMenu($this);
        }

        return $this;
    }

    public function removeMenu(Formule $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getMenu() === $this) {
                $menu->setMenu(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->title;
    }
}
