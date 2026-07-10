<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260601135254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parfum_commande_produit (parfum_id INT NOT NULL, commande_produit_id INT NOT NULL, INDEX IDX_AB3E45ADCECF0658 (parfum_id), INDEX IDX_AB3E45AD97F6521D (commande_produit_id), PRIMARY KEY (parfum_id, commande_produit_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE parfum_commande_produit ADD CONSTRAINT FK_AB3E45ADCECF0658 FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commande_produit ADD CONSTRAINT FK_AB3E45AD97F6521D FOREIGN KEY (commande_produit_id) REFERENCES commande_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commandeproduit DROP FOREIGN KEY `FK_43CB40F252A485A4`');
        $this->addSql('ALTER TABLE parfum_commandeproduit DROP FOREIGN KEY `FK_43CB40F2CECF0658`');
        $this->addSql('DROP TABLE parfum_commandeproduit');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY `FK_6EEAA67D52A485A4`');
        $this->addSql('DROP INDEX IDX_6EEAA67D52A485A4 ON commande');
        $this->addSql('ALTER TABLE commande CHANGE commandeproduit_id commande_produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D97F6521D FOREIGN KEY (commande_produit_id) REFERENCES commande_produit (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D97F6521D ON commande (commande_produit_id)');
        $this->addSql('ALTER TABLE parfum ADD family VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parfum_commandeproduit (parfum_id INT NOT NULL, commandeproduit_id INT NOT NULL, INDEX IDX_43CB40F2CECF0658 (parfum_id), INDEX IDX_43CB40F252A485A4 (commandeproduit_id), PRIMARY KEY (parfum_id, commandeproduit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE parfum_commandeproduit ADD CONSTRAINT `FK_43CB40F252A485A4` FOREIGN KEY (commandeproduit_id) REFERENCES commande_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commandeproduit ADD CONSTRAINT `FK_43CB40F2CECF0658` FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commande_produit DROP FOREIGN KEY FK_AB3E45ADCECF0658');
        $this->addSql('ALTER TABLE parfum_commande_produit DROP FOREIGN KEY FK_AB3E45AD97F6521D');
        $this->addSql('DROP TABLE parfum_commande_produit');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D97F6521D');
        $this->addSql('DROP INDEX IDX_6EEAA67D97F6521D ON commande');
        $this->addSql('ALTER TABLE commande CHANGE commande_produit_id commandeproduit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT `FK_6EEAA67D52A485A4` FOREIGN KEY (commandeproduit_id) REFERENCES commande_produit (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D52A485A4 ON commande (commandeproduit_id)');
        $this->addSql('ALTER TABLE parfum DROP family');
    }
}
