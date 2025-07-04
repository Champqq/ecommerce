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

    #[ORM\Column(type: Types::STRING, length: 10)]
    private string $size;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $unitPrice = 0.00;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $total = 0.00;

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
        $this->unitPrice = round($unitPrice, 2);
        $this->recalculateTotal();
        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = round($total, 2);
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
        $this->total = round($this->quantity * $this->unitPrice, 2);
    }

    public function __toString(): string
    {
        return $this->getProduct()->getName() . ' (' . $this->getSize() . ') x' . $this->getQuantity();
    }

    public function decreaseStock(): void
    {
        $size = $this->getSize();

        foreach ($this->getProduct()->getAttributes() as $attribute) {
            if ($attribute->getValue() === $size) {
                $attribute->decreaseStock($this->quantity);
                break;
            }
        }
    }
}
