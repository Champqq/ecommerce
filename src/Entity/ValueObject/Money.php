<?php

declare(strict_types=1);

namespace App\Entity\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;
use Money\Currency;
use Money\Money as MoneyLib;

#[ORM\Embeddable]
class Money
{
    #[ORM\Column(type: "string", length: 3)]
    private string $currency;

    #[ORM\Column(type: "string")]
    private string $amount;

    public function __construct(int|string $amount, string $currency)
    {
        if (!is_numeric($amount)) {
            throw new InvalidArgumentException('Amount must be numeric');
        }

        $this->amount = (string)$amount;
        $this->currency = strtoupper($currency);
    }

    public function toMoney(): MoneyLib
    {
        return new MoneyLib($this->amount, new Currency($this->currency));
    }

    public static function fromMoney(MoneyLib $money): self
    {
        return new self($money->getAmount(), $money->getCurrency()->getCode());
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
