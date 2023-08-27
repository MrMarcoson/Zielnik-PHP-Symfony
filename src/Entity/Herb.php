<?php

namespace App\Entity;

use App\Repository\HerbRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HerbRepository::class)]
class Herb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 2048, nullable: true)]
    private ?string $imagePath = null;

    #[ORM\ManyToMany(targetEntity: Recipe::class, mappedBy: 'herbs')]
    private Collection $recipes;

    #[ORM\ManyToMany(targetEntity: Property::class, inversedBy: 'herbs')]
    private Collection $properties;

    #[ORM\ManyToOne(inversedBy: 'herbs')]
    private ?User $author = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateOfEntry = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $glagolitic = null;

    public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->properties = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(?string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection<int, Recipe>
     */
    public function getRecipes(): Collection
    {
        return $this->recipes;
    }

    public function addRecipe(Recipe $recipe): static
    {
        if (!$this->recipes->contains($recipe)) {
            $this->recipes->add($recipe);
            $recipe->addHerb($this);
        }

        return $this;
    }

    public function removeRecipe(Recipe $recipe): static
    {
        if ($this->recipes->removeElement($recipe)) {
            $recipe->removeHerb($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Property>
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(Property $property): static
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
        }

        return $this;
    }

    public function removeProperty(Property $property): static
    {
        $this->properties->removeElement($property);

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getDateOfEntry(): ?\DateTimeInterface
    {
        return $this->dateOfEntry;
    }

    public function setDateOfEntry(?\DateTimeInterface $dateOfEntry): static
    {
        $this->dateOfEntry = $dateOfEntry;

        return $this;
    }

    public function getGlagolitic(): ?string
    {
        return $this->glagolitic;
    }

    public function setGlagolitic(?string $glagolitic): static
    {
        $this->glagolitic = $glagolitic;

        return $this;
    }
}
