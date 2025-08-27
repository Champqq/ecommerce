<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\ValueObject\Money;
use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money as MoneyLib;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ApiResource]
#[ORM\Table(name: '`order`')]
class Order
{
    public const STATUS_CART = 'cart';
    public const STATUS_NEW = 'new';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 20, unique: true)]
    private ?string $number = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private string $status = self::STATUS_CART;

    #[ORM\Embedded(class: Money::class)]
    private Money $total;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'order', cascade: ['persist', 'remove'])]
    private Collection $items;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $customerEmail = null;

    public function __construct()
    {
        $this->total = new Money(0, 'USD');
        $this->items = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->number = $this->generateOrderNumber();
    }

    private function generateOrderNumber(): string
    {
        return 'ORD-' . date('Y') . '-' . str_pad((string)random_int(1, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function isCart(): bool
    {
        return $this->status === self::STATUS_CART;
    }

    public function isNew(): bool
    {
        return $this->status === self::STATUS_NEW;
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

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): void
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    public function setCustomerEmail(?string $customerEmail): static
    {
        $this->customerEmail = $customerEmail;

        return $this;
    }
}
