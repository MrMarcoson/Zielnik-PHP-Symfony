<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Herb::class, mappedBy: 'properties')]
    private Collection $herbs;

    public function __construct()
    {
        $this->herbs = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return Collection<int, Herb>
     */
    public function getHerbs(): Collection
    {
        return $this->herbs;
    }

    public function addHerb(Herb $herb): static
    {
        if (!$this->herbs->contains($herb)) {
            $this->herbs->add($herb);
            $herb->addProperty($this);
        }

        return $this;
    }

    public function removeHerb(Herb $herb): static
    {
        if ($this->herbs->removeElement($herb)) {
            $herb->removeProperty($this);
        }

        return $this;
    }
}
