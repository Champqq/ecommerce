<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\ValueObject\Money;
use App\Repository\OrderItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money as MoneyLib;

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

    #[ORM\Embedded(class: Money::class)]
    private Money $unitPrice;

    #[ORM\Embedded(class: Money::class)]
    private Money $total;

    public function __construct()
    {
        $this->total = new Money(0, 'USD');
        $this->unitPrice = new Money(0, 'USD');
    }

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

    public function setUnitPriceMoney(MoneyLib $money): void
    {
        $this->unitPrice = Money::fromMoney($money);
        $this->recalculateTotal();
    }

    public function getUnitPriceMoney(): MoneyLib
    {
        return $this->unitPrice->toMoney();
    }

    public function getUnitPrice(): Money
    {
        return $this->unitPrice;
    }

    public function setTotalMoney(MoneyLib $money): void
    {
        $this->total = Money::fromMoney($money);
    }

    public function getTotalMoney(): MoneyLib
    {
        return $this->total->toMoney();
    }

    public function getTotal(): Money
    {
        return $this->total;
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
        $price = $this->unitPrice->toMoney();
        $total = $price->multiply($this->quantity);
        $this->total = Money::fromMoney($total);
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
