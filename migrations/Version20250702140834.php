<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250702140834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order` ADD customer_email VARCHAR(255) DEFAULT NULL, CHANGE total total NUMERIC(10, 2) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE order_item CHANGE size size VARCHAR(10) NOT NULL
        SQL
        );
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

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            DROP TABLE size
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product_attribute CHANGE stock stock INT DEFAULT 0 NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE product CHANGE description description TEXT DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE order_item CHANGE size size VARCHAR(255) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE `order` DROP customer_email, CHANGE total total NUMERIC(10, 0) NOT NULL
        SQL
        );
    }
}
