<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250702131548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE description description TEXT DEFAULT NULL
        SQL
        );

        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute CHANGE stock stock INT NOT NULL DEFAULT 0
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE description description LONGTEXT DEFAULT NULL
        SQL
        );

        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute CHANGE stock stock INT NOT NULL
        SQL
        );
    }
}
