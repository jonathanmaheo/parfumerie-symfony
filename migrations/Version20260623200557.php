<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623200557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum ADD picture70 VARCHAR(255) DEFAULT NULL, ADD picture100 VARCHAR(255) DEFAULT NULL, ADD price35 DOUBLE PRECISION DEFAULT NULL, ADD price70 DOUBLE PRECISION DEFAULT NULL, ADD price100 DOUBLE PRECISION DEFAULT NULL, CHANGE picture35 picture35 VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum DROP picture70, DROP picture100, DROP price35, DROP price70, DROP price100, CHANGE picture35 picture35 LONGTEXT DEFAULT NULL');
    }
}
