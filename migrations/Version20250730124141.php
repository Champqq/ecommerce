<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250730124141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE product
            ADD price_currency VARCHAR(3) DEFAULT NULL,
            ADD price_amount VARCHAR(20) DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE `order`
            ADD total_currency VARCHAR(3) DEFAULT NULL,
            ADD total_amount VARCHAR(20) DEFAULT NULL'
        );
        $this->addSql(
            'ALTER TABLE order_item
            ADD unit_price_currency VARCHAR(3) DEFAULT NULL,
            ADD unit_price_amount VARCHAR(20) DEFAULT NULL,
            ADD total_currency VARCHAR(3) DEFAULT NULL,
            ADD total_amount VARCHAR(20) DEFAULT NULL'
        );

        $this->addSql(
            "UPDATE product
            SET price_currency = 'USD',
            price_amount = CAST(price * 100 AS CHAR)"
        );
        $this->addSql(
            "UPDATE `order`
            SET total_currency = 'USD',
            total_amount = CAST(total * 100 AS CHAR)"
        );
        $this->addSql(
            "UPDATE order_item
            SET unit_price_currency = 'USD',
            unit_price_amount = CAST(unit_price * 100 AS CHAR),
            total_currency = 'USD',
            total_amount = CAST(total * 100 AS CHAR)"
        );

        $this->addSql(
            'ALTER TABLE product
            MODIFY price_currency VARCHAR(3) NOT NULL,
            MODIFY price_amount VARCHAR(20) NOT NULL'
        );
        $this->addSql(
            'ALTER TABLE `order`
            MODIFY total_currency VARCHAR(3) NOT NULL,
            MODIFY total_amount VARCHAR(20) NOT NULL'
        );
        $this->addSql(
            'ALTER TABLE order_item
            MODIFY unit_price_currency VARCHAR(3) NOT NULL,
            MODIFY unit_price_amount VARCHAR(20) NOT NULL,
            MODIFY total_currency VARCHAR(3) NOT NULL,
            MODIFY total_amount VARCHAR(20) NOT NULL'
        );

        $this->addSql(
            'ALTER TABLE product
            DROP price'
        );
        $this->addSql(
            'ALTER TABLE `order`
            DROP total'
        );
        $this->addSql(
            'ALTER TABLE order_item
            DROP unit_price,
            DROP total'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE product
            ADD price NUMERIC(10, 2) NOT NULL,
            DROP price_currency,
            DROP price_amount'
        );
        $this->addSql(
            'ALTER TABLE `order`
            ADD total NUMERIC(10, 2) NOT NULL,
            DROP total_currency,
            DROP total_amount'
        );
        $this->addSql(
            'ALTER TABLE order_item
            ADD unit_price NUMERIC(10, 2) NOT NULL,
            ADD total NUMERIC(10, 2) NOT NULL,
            DROP unit_price_currency,
            DROP unit_price_amount,
            DROP total_currency,
            DROP total_amount'
        );
    }
}
