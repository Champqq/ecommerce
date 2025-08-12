<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Entity\ValueObject\Money;
use App\Repository\ProductRepository;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Money\Money as MoneyLib;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Embedded(class: Money::class)]
    private Money $price;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinTable(name: 'product_categories')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', cascade: ['persist', 'remove'])]
    private Collection $attributes;

    #[ORM\OneToMany(targetEntity: OrderItem::class, mappedBy: 'product')]
    private Collection $orderItems;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $views = 0;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->price = new Money(0, 'USD');
        $this->categories = new ArrayCollection();
        $this->attributes = new ArrayCollection();
        $this->orderItems = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
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

    public function setPrice(MoneyLib $money): void
    {
        $this->price = Money::fromMoney($money);
    }

    public function getPriceMoney(): MoneyLib
    {
        return $this->price->toMoney();
    }

    public function getPrice(): Money
    {
        return $this->price;
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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function setViews(int $views): static
    {
        $this->views = $views;
        return $this;
    }

    public function updateViews(int $newViews): static
    {
        $this->views += $newViews;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getValue(): array
    {
        return $this->attributes->getValues();
    }

    public function setAttributes(Collection $attributes): static
    {
        $this->attributes = new ArrayCollection();

        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }

        return $this;
    }

    public function addAttribute(ProductAttribute $attribute): void
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
            $attribute->setProduct($this);
        }
    }

    public function removeAttribute(ProductAttribute $attribute): void
    {
        if ($this->attributes->removeElement($attribute) && $attribute->getProduct() === $this) {
            $attribute->setProduct(null);
        }
    }
}
