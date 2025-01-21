<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117095426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE uantenne (id INT AUTO_INCREMENT NOT NULL, depot_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, mag_hosi VARCHAR(255) DEFAULT NULL, id_client VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, defaut TINYINT(1) DEFAULT NULL, created DATETIME DEFAULT NULL, updated DATETIME DEFAULT NULL, pharmacy_centrale_flag INT DEFAULT NULL, INDEX IDX_1AE81D0C8510D4DE (depot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE udepot (id INT AUTO_INCREMENT NOT NULL, dossier_id INT DEFAULT NULL, sce_hosi VARCHAR(255) NOT NULL, id_client VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, autre_information LONGTEXT DEFAULT NULL, INDEX IDX_6B9B4170611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE uantenne ADD CONSTRAINT FK_1AE81D0C8510D4DE FOREIGN KEY (depot_id) REFERENCES udepot (id)');
        $this->addSql('ALTER TABLE udepot ADD CONSTRAINT FK_6B9B4170611C0C56 FOREIGN KEY (dossier_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE uarticle CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE uantenne DROP FOREIGN KEY FK_1AE81D0C8510D4DE');
        $this->addSql('ALTER TABLE udepot DROP FOREIGN KEY FK_6B9B4170611C0C56');
        $this->addSql('DROP TABLE uantenne');
        $this->addSql('DROP TABLE udepot');
        $this->addSql('ALTER TABLE uarticle CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
