<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623125010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parfum_family (parfum_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_4CA3AF32CECF0658 (parfum_id), INDEX IDX_4CA3AF32C35E566A (family_id), PRIMARY KEY (parfum_id, family_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE parfum_family ADD CONSTRAINT FK_4CA3AF32CECF0658 FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_family ADD CONSTRAINT FK_4CA3AF32C35E566A FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum DROP family');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum_family DROP FOREIGN KEY FK_4CA3AF32CECF0658');
        $this->addSql('ALTER TABLE parfum_family DROP FOREIGN KEY FK_4CA3AF32C35E566A');
        $this->addSql('DROP TABLE parfum_family');
        $this->addSql('ALTER TABLE parfum ADD family VARCHAR(100) DEFAULT NULL');
    }
}
