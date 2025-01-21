<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121103030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE list_position (id INT AUTO_INCREMENT NOT NULL, position VARCHAR(255) DEFAULT NULL, is_reserved TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD position_id INT DEFAULT NULL, ADD position_historique_id INT DEFAULT NULL, ADD etat VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E3DD842E46 FOREIGN KEY (position_id) REFERENCES list_position (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E36E21D1B0 FOREIGN KEY (position_historique_id) REFERENCES list_position (id)');
        $this->addSql('CREATE INDEX IDX_E12546E3DD842E46 ON livraison_stock_cab (position_id)');
        $this->addSql('CREATE INDEX IDX_E12546E36E21D1B0 ON livraison_stock_cab (position_historique_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E3DD842E46');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E36E21D1B0');
        $this->addSql('DROP TABLE list_position');
        $this->addSql('DROP INDEX IDX_E12546E3DD842E46 ON livraison_stock_cab');
        $this->addSql('DROP INDEX IDX_E12546E36E21D1B0 ON livraison_stock_cab');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP position_id, DROP position_historique_id, DROP etat');
    }
}
