<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117151233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison_stock_lot (id INT AUTO_INCREMENT NOT NULL, livraison_cab_id INT DEFAULT NULL, lot VARCHAR(255) DEFAULT NULL, date_peremption DATE DEFAULT NULL, quantite INT DEFAULT NULL, quantite_retour DOUBLE PRECISION DEFAULT NULL, prix_vente_ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_achat_ht DOUBLE PRECISION DEFAULT NULL, mh DOUBLE PRECISION DEFAULT NULL, mr DOUBLE PRECISION DEFAULT NULL, mtva DOUBLE PRECISION DEFAULT NULL, mtt DOUBLE PRECISION DEFAULT NULL, date_sys DATETIME DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, valeur_a DOUBLE PRECISION DEFAULT NULL, merge DOUBLE PRECISION DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_802E9901BABAA5EA (livraison_cab_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pnature_prix (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livraison_stock_lot ADD CONSTRAINT FK_802E9901BABAA5EA FOREIGN KEY (livraison_cab_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_stock_details DROP FOREIGN KEY FK_DB29B8EFBABAA5EA');
        $this->addSql('DROP TABLE livraison_stock_details');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison_stock_details (id INT AUTO_INCREMENT NOT NULL, livraison_cab_id INT DEFAULT NULL, lot VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_peremption DATE DEFAULT NULL, quantite INT DEFAULT NULL, quantite_retour DOUBLE PRECISION DEFAULT NULL, prix_vente_ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_achat_ht DOUBLE PRECISION DEFAULT NULL, mh DOUBLE PRECISION DEFAULT NULL, mr DOUBLE PRECISION DEFAULT NULL, mtva DOUBLE PRECISION DEFAULT NULL, mtt DOUBLE PRECISION DEFAULT NULL, date_sys DATETIME DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, valeur_a DOUBLE PRECISION DEFAULT NULL, merge DOUBLE PRECISION DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_DB29B8EFBABAA5EA (livraison_cab_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE livraison_stock_details ADD CONSTRAINT FK_DB29B8EFBABAA5EA FOREIGN KEY (livraison_cab_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_stock_lot DROP FOREIGN KEY FK_802E9901BABAA5EA');
        $this->addSql('DROP TABLE livraison_stock_lot');
        $this->addSql('DROP TABLE pnature_prix');
    }
}
