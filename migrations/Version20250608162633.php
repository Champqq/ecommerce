<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250608162633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order`
                CHANGE total total DOUBLE PRECISION NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE order_item
                ADD size VARCHAR(255) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product
                DROP has_variations
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product
                ADD has_variations TINYINT(1) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order`
                CHANGE total total INT NOT NULL
        SQL
        );
    }
}
