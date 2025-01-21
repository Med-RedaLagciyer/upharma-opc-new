<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117151636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_lot ADD nature_prix_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_lot ADD CONSTRAINT FK_802E99018CC46927 FOREIGN KEY (nature_prix_id) REFERENCES pnature_prix (id)');
        $this->addSql('CREATE INDEX IDX_802E99018CC46927 ON livraison_stock_lot (nature_prix_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_lot DROP FOREIGN KEY FK_802E99018CC46927');
        $this->addSql('DROP INDEX IDX_802E99018CC46927 ON livraison_stock_lot');
        $this->addSql('ALTER TABLE livraison_stock_lot DROP nature_prix_id');
    }
}
