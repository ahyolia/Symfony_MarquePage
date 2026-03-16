<?php

namespace App\Entity;

use App\Repository\MarquePageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarquePageRepository::class)]
class MarquePage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $URL = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date_creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(name: 'mots_cles', length: 255, nullable: true)]
    private ?string $motsCles = null;

    /**
     * @var Collection<int, MotsCle>
     */
    #[ORM\ManyToMany(targetEntity: MotsCle::class, inversedBy: 'marquePages')]
    private Collection $mots_cles;

    public function __construct()
    {
        $this->mots_cles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(string $URL): static
    {
        $this->URL = $URL;

        return $this;
    }

    public function getDateCreation(): ?\DateTime
    {
        return $this->date_creation;
    }

    public function setDateCreation(\DateTime $date_creation): static
    {
        $this->date_creation = $date_creation;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection<int, MotsCle>
     */
    public function getMotsCles(): Collection
    {
        return $this->mots_cles;
    }

    public function addMotsCle(MotsCle $motsCle): static
    {
        if (!$this->mots_cles->contains($motsCle)) {
            $this->mots_cles->add($motsCle);
        }

        return $this;
    }

    public function removeMotsCle(MotsCle $motsCle): static
    {
        $this->mots_cles->removeElement($motsCle);

        return $this;
    }

}
