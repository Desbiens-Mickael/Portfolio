<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721093803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD updated_at DATETIME DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE techno ADD updated_at DATETIME DEFAULT NULL, CHANGE image image VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP updated_at, CHANGE image image VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE techno DROP updated_at, CHANGE image image VARCHAR(100) NOT NULL');
    }
}
