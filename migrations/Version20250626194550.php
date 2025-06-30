<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250626194550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute ADD stock INT NOT NULL, CHANGE value value VARCHAR(255) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user CHANGE roles roles JSON DEFAULT NULL
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE created_at created_at DATETIME NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute DROP stock, CHANGE value value LONGTEXT NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `user` CHANGE roles roles JSON NOT NULL
        SQL
        );
    }
}
