<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $quantity = 1;

    #[ORM\Column(type: Types::STRING)]
    private string $size;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $unitPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $total = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrder(): ?Order
    {
        return $this->order;
    }

    public function setOrder(?Order $order): static
    {
        $this->order = $order;
        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;
        return $this;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;
        return $this;
    }

    public function getUnitPrice(): ?float
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(float $unitPrice): static
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;
        return $this;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function getSize(): string
    {
        return $this->size;
    }

    public function updateQuantity(int $newQuantity): void
    {
        $this->quantity = $newQuantity;
        $this->recalculateTotal();
    }

    public function increaseQuantity(int $additive): void
    {
        $this->updateQuantity($this->quantity + $additive);
    }

    private function recalculateTotal(): void
    {
        $this->total = $this->quantity * $this->unitPrice;
    }
}
