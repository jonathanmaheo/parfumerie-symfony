<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623211505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum ADD sillage INT DEFAULT NULL, ADD tenue INT DEFAULT NULL, ADD note_tete LONGTEXT DEFAULT NULL, ADD note_coeur LONGTEXT DEFAULT NULL, ADD note_fond LONGTEXT DEFAULT NULL, DROP picture35, DROP picture70, DROP picture100, DROP price35, DROP price70, DROP price100');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum ADD picture35 VARCHAR(255) DEFAULT NULL, ADD picture70 VARCHAR(255) DEFAULT NULL, ADD picture100 VARCHAR(255) DEFAULT NULL, ADD price35 DOUBLE PRECISION DEFAULT NULL, ADD price70 DOUBLE PRECISION DEFAULT NULL, ADD price100 DOUBLE PRECISION DEFAULT NULL, DROP sillage, DROP tenue, DROP note_tete, DROP note_coeur, DROP note_fond');
    }
}
