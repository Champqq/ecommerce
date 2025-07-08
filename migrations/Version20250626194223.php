<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250626194223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order` CHANGE total total NUMERIC(10, 0) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE order_item CHANGE size size VARCHAR(255) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL
        );
        $this->addSql(
            <<<'SQL'
            UPDATE product_attribute SET value = LEFT(value, 10) WHERE CHAR_LENGTH(value) > 10
        SQL
        );
        $this->addSql(
            <<<'SQL'
            UPDATE product_attribute SET value = '' WHERE value IS NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute ADD stock INT NOT NULL DEFAULT 0, CHANGE value value VARCHAR(10) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            UPDATE user SET roles = '["ROLE_USER"]' WHERE roles IS NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user CHANGE roles roles JSON NOT NULL
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE description description LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE order_item CHANGE size size VARCHAR(255) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute DROP stock, CHANGE value value LONGTEXT NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order` CHANGE total total DOUBLE PRECISION NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `user` CHANGE roles roles JSON NOT NULL
        SQL
        );
    }
}
