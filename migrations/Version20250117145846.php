<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117145846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_details DROP FOREIGN KEY FK_DB29B8EF274D3BD1');
        $this->addSql('DROP INDEX IDX_DB29B8EF274D3BD1 ON livraison_stock_details');
        $this->addSql('ALTER TABLE livraison_stock_details CHANGE livraison_det_id livraison_cab_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_details ADD CONSTRAINT FK_DB29B8EFBABAA5EA FOREIGN KEY (livraison_cab_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('CREATE INDEX IDX_DB29B8EFBABAA5EA ON livraison_stock_details (livraison_cab_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_details DROP FOREIGN KEY FK_DB29B8EFBABAA5EA');
        $this->addSql('DROP INDEX IDX_DB29B8EFBABAA5EA ON livraison_stock_details');
        $this->addSql('ALTER TABLE livraison_stock_details CHANGE livraison_cab_id livraison_det_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_details ADD CONSTRAINT FK_DB29B8EF274D3BD1 FOREIGN KEY (livraison_det_id) REFERENCES livraison_stock_det (id)');
        $this->addSql('CREATE INDEX IDX_DB29B8EF274D3BD1 ON livraison_stock_details (livraison_det_id)');
    }
}
