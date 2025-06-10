<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductAttributeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductAttributeRepository::class)]
class ProductAttribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'attributes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(type: 'text')]
    private ?string $value = null;

    public function getId(): ?int
    {
        return $this->id; 
    }
    public function getProduct(): ?Product
    {
        return $this->product; 
    }
    public function setProduct(?Product $product): static
    {
        $this->product = $product; return $this; 
    }
    public function getName(): ?string
    {
        return $this->name; 
    }
    public function setName(string $name): static
    {
        $this->name = $name; return $this; 
    }
    public function getValue(): ?string
    {
        return $this->value; 
    }
    public function setValue(string $value): static
    {
        $this->value = $value; return $this; 
    }
}
