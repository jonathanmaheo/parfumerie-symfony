<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623202237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum_variant ADD size VARCHAR(20) NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD price DOUBLE PRECISION NOT NULL, ADD stock INT NOT NULL, ADD parfum_id INT NOT NULL');
        $this->addSql('ALTER TABLE parfum_variant ADD CONSTRAINT FK_C5C423DFCECF0658 FOREIGN KEY (parfum_id) REFERENCES parfum (id)');
        $this->addSql('CREATE INDEX IDX_C5C423DFCECF0658 ON parfum_variant (parfum_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum_variant DROP FOREIGN KEY FK_C5C423DFCECF0658');
        $this->addSql('DROP INDEX IDX_C5C423DFCECF0658 ON parfum_variant');
        $this->addSql('ALTER TABLE parfum_variant DROP size, DROP image, DROP price, DROP stock, DROP parfum_id');
    }
}
