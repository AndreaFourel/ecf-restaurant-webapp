<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: "decimal", precision: 5, scale: 2)]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MealCategory $mealCategory = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getMealCategory(): ?MealCategory
    {
        return $this->mealCategory;
    }

    public function setMealCategory(?MealCategory $mealCategory): self
    {
        $this->mealCategory = $mealCategory;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

}
