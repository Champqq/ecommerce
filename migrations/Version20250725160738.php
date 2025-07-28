<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250725160738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE user CHANGE password password VARCHAR(255) DEFAULT NULL,
            CHANGE github_id github_id INT DEFAULT NULL,
            CHANGE google_id google_id VARCHAR(30) DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE `user` CHANGE github_id github_id VARCHAR(255) DEFAULT NULL,
            CHANGE google_id google_id VARCHAR(255) DEFAULT NULL,
            CHANGE password password VARCHAR(255) NOT NULL'
        );
    }
}
