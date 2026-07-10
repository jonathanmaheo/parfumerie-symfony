<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260623222455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE parfum_commande_produit DROP FOREIGN KEY `FK_AB3E45AD97F6521D`');
        $this->addSql('ALTER TABLE parfum_commande_produit DROP FOREIGN KEY `FK_AB3E45ADCECF0658`');
        $this->addSql('ALTER TABLE parfum_family DROP FOREIGN KEY `FK_4CA3AF32C35E566A`');
        $this->addSql('ALTER TABLE parfum_family DROP FOREIGN KEY `FK_4CA3AF32CECF0658`');
        $this->addSql('DROP TABLE parfum_commande_produit');
        $this->addSql('DROP TABLE parfum_family');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE parfum_commande_produit (parfum_id INT NOT NULL, commande_produit_id INT NOT NULL, INDEX IDX_AB3E45ADCECF0658 (parfum_id), INDEX IDX_AB3E45AD97F6521D (commande_produit_id), PRIMARY KEY (parfum_id, commande_produit_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE parfum_family (parfum_id INT NOT NULL, family_id INT NOT NULL, INDEX IDX_4CA3AF32CECF0658 (parfum_id), INDEX IDX_4CA3AF32C35E566A (family_id), PRIMARY KEY (parfum_id, family_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE parfum_commande_produit ADD CONSTRAINT `FK_AB3E45AD97F6521D` FOREIGN KEY (commande_produit_id) REFERENCES commande_produit (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_commande_produit ADD CONSTRAINT `FK_AB3E45ADCECF0658` FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_family ADD CONSTRAINT `FK_4CA3AF32C35E566A` FOREIGN KEY (family_id) REFERENCES family (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE parfum_family ADD CONSTRAINT `FK_4CA3AF32CECF0658` FOREIGN KEY (parfum_id) REFERENCES parfum (id) ON DELETE CASCADE');
    }
}
