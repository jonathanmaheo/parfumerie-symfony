<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260709001403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY `FK_6EEAA67D97F6521D`');
        $this->addSql('DROP INDEX IDX_6EEAA67D97F6521D ON commande');
        $this->addSql('ALTER TABLE commande DROP commande_produit_id');
        $this->addSql('ALTER TABLE commande_produit ADD parfum_variant_id INT DEFAULT NULL, ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E87C234C630 FOREIGN KEY (parfum_variant_id) REFERENCES parfum_variant (id)');
        $this->addSql('ALTER TABLE commande_produit ADD CONSTRAINT FK_DF1E9E8782EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_DF1E9E87C234C630 ON commande_produit (parfum_variant_id)');
        $this->addSql('CREATE INDEX IDX_DF1E9E8782EA2E54 ON commande_produit (commande_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD commande_produit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT `FK_6EEAA67D97F6521D` FOREIGN KEY (commande_produit_id) REFERENCES commande_produit (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D97F6521D ON commande (commande_produit_id)');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E87C234C630');
        $this->addSql('ALTER TABLE commande_produit DROP FOREIGN KEY FK_DF1E9E8782EA2E54');
        $this->addSql('DROP INDEX IDX_DF1E9E87C234C630 ON commande_produit');
        $this->addSql('DROP INDEX IDX_DF1E9E8782EA2E54 ON commande_produit');
        $this->addSql('ALTER TABLE commande_produit DROP parfum_variant_id, DROP commande_id');
    }
}
