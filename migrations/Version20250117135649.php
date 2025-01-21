<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117135649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab ADD id_reference_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E33584ABDB FOREIGN KEY (id_reference_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('CREATE INDEX IDX_E12546E33584ABDB ON livraison_stock_cab (id_reference_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E33584ABDB');
        $this->addSql('DROP INDEX IDX_E12546E33584ABDB ON livraison_stock_cab');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP id_reference_id');
    }
}
