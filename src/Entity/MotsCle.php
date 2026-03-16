<?php

namespace App\Entity;

use App\Repository\MotsCleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MotsCleRepository::class)]
class MotsCle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, MarquePage>
     */
    #[ORM\ManyToMany(targetEntity: MarquePage::class, mappedBy: 'mots_cles')]
    private Collection $marquePages;

    public function __construct()
    {
        $this->marquePages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, MarquePage>
     */
    public function getMarquePages(): Collection
    {
        return $this->marquePages;
    }

    public function addMarquePage(MarquePage $marquePage): static
    {
        if (!$this->marquePages->contains($marquePage)) {
            $this->marquePages->add($marquePage);
            $marquePage->addMotsCle($this);
        }

        return $this;
    }

    public function removeMarquePage(MarquePage $marquePage): static
    {
        if ($this->marquePages->removeElement($marquePage)) {
            $marquePage->removeMotsCle($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nom ?? '';
    }
}
