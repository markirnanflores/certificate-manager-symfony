<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230604181338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificates CHANGE certificate certificate MEDIUMTEXT NOT NULL, CHANGE private_key private_key MEDIUMTEXT NOT NULL, CHANGE intermediate_ca intermediate_ca MEDIUMTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certificates CHANGE certificate certificate VARCHAR(255) NOT NULL, CHANGE private_key private_key VARCHAR(255) NOT NULL, CHANGE intermediate_ca intermediate_ca VARCHAR(255) DEFAULT NULL');
    }
}
