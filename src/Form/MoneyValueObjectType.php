<?php

declare(strict_types=1);

namespace App\Form;

use Money\Currency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\CallbackTransformer;
use Money\Money;

class MoneyValueObjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(
            new CallbackTransformer(
                function ($value) {
                    if (!$value instanceof Money) {
                        return null;
                    }
                    return $value->getAmount() / 100;
                },
                function ($value) {
                    if ($value === null || $value === '') {
                        return null;
                    }
                    return new Money((int) round($value * 100), new Currency('USD'));
                }
            )
        );
    }

    public function getParent(): string
    {
        return MoneyType::class;
    }
}
