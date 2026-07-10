<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260522111923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parfum_commandeproduit (parfum_id INT NOT NULL, commandeproduit_id INT NOT NULL, INDEX IDX_43CB40F2CECF0658 (parfum_id), INDEX IDX_43CB40F252A485A4 (commandeproduit_id), PRIMARY KEY (parfum_id, commandeproduit_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE parfum_commandeproduit ADD CONSTRAINT FK_43CB40F2CECF0658 FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commandeproduit ADD CONSTRAINT FK_43CB40F252A485A4 FOREIGN KEY (commandeproduit_id) REFERENCES commande_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande ADD client_id INT DEFAULT NULL, ADD commandeproduit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D52A485A4 FOREIGN KEY (commandeproduit_id) REFERENCES commande_produit (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D52A485A4 ON commande (commandeproduit_id)');
        $this->addSql('ALTER TABLE parfum ADD brand_id INT DEFAULT NULL, DROP brand');
        $this->addSql('ALTER TABLE parfum ADD CONSTRAINT FK_F295BD4C44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_F295BD4C44F5D008 ON parfum (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum_commandeproduit DROP FOREIGN KEY FK_43CB40F2CECF0658');
        $this->addSql('ALTER TABLE parfum_commandeproduit DROP FOREIGN KEY FK_43CB40F252A485A4');
        $this->addSql('DROP TABLE parfum_commandeproduit');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D52A485A4');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('DROP INDEX IDX_6EEAA67D52A485A4 ON commande');
        $this->addSql('ALTER TABLE commande DROP client_id, DROP commandeproduit_id');
        $this->addSql('ALTER TABLE parfum DROP FOREIGN KEY FK_F295BD4C44F5D008');
        $this->addSql('DROP INDEX IDX_F295BD4C44F5D008 ON parfum');
        $this->addSql('ALTER TABLE parfum ADD brand LONGTEXT DEFAULT NULL, DROP brand_id');
    }
}
