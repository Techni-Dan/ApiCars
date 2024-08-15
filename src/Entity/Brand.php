<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getCars", "getBrand", "getModels"])]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[Groups(["getBrand"])]
    private ?string $name = null;

    /**
     * @var Collection<int, Model>
     */
    #[ORM\OneToMany(targetEntity: Model::class, mappedBy: 'brand')]
    private Collection $model;

    /**
     * @var Collection<int, Car>
     */
    #[ORM\OneToMany(targetEntity: Car::class, mappedBy: 'brand')]
    private Collection $cars;

    public function __construct()
    {
        $this->model = new ArrayCollection();
        $this->cars = new ArrayCollection();
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
     * @return Collection<int, Model>
     */
    public function getModel(): Collection
    {
        return $this->model;
    }

    public function addModel(Model $model): static
    {
        if (!$this->model->contains($model)) {
            $this->model->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): static
    {
        if ($this->model->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): static
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setBrand($this);
        }

        return $this;
    }

    public function removeCar(Car $car): static
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getBrand() === $this) {
                $car->setBrand(null);
            }
        }

        return $this;
    }
}
