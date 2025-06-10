<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $price = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'product_categories')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $attributes;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'product')]
    private Collection $orderItems;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: 'integer')]
    private int $views = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
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
        $this->name = $name; return $this; 
    }
    public function getDescription(): ?string
    {
        return $this->description; 
    }
    public function setDescription(?string $description): static
    {
        $this->description = $description; return $this; 
    }
    public function getPrice(): ?float
    {
        return $this->price; 
    }
    public function setPrice(float $price): static
    {
        $this->price = $price; return $this; 
    }
    public function getCategories(): Collection
    {
        return $this->categories; 
    }
    public function getAttributes(): Collection
    {
        return $this->attributes; 
    }
    public function getOrderItems(): Collection
    {
        return $this->orderItems; 
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt; 
    }
    public function setCreatedAt(\DateTimeInterface $createdAt): Product
    {
        $this->createdAt = $createdAt; return $this; 
    }
    public function getViews(): int
    {
        return $this->views; 
    }
    public function setViews(int $views): Product
    {
        $this->views = $views; return $this; 
    }
    public function incrementViews(): Product
    {
        $this->views++; return $this; 
    }
    public function getImage(): ?string
    {
        return $this->image; 
    }
    public function setImage(?string $image): static
    {
        $this->image = $image; return $this; 
    }
    public function getValue(): array
    {
        return $this->attributes->getValues(); 
    }
}
