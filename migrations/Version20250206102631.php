<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206102631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_stock_det ADD lign_cd INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_det ADD demande_det_id INT DEFAULT NULL, ADD lign_bl INT DEFAULT NULL, ADD lign_cd INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_det ADD CONSTRAINT FK_74D220334C6C79D4 FOREIGN KEY (demande_det_id) REFERENCES demande_stock_det (id)');
        $this->addSql('CREATE INDEX IDX_74D220334C6C79D4 ON livraison_stock_det (demande_det_id)');
        $this->addSql('ALTER TABLE livraison_stock_lot ADD livraison_det_id INT DEFAULT NULL, ADD lign_bl INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_lot ADD CONSTRAINT FK_802E9901274D3BD1 FOREIGN KEY (livraison_det_id) REFERENCES livraison_stock_det (id)');
        $this->addSql('CREATE INDEX IDX_802E9901274D3BD1 ON livraison_stock_lot (livraison_det_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_stock_det DROP lign_cd');
        $this->addSql('ALTER TABLE livraison_stock_det DROP FOREIGN KEY FK_74D220334C6C79D4');
        $this->addSql('DROP INDEX IDX_74D220334C6C79D4 ON livraison_stock_det');
        $this->addSql('ALTER TABLE livraison_stock_det DROP demande_det_id, DROP lign_bl, DROP lign_cd');
        $this->addSql('ALTER TABLE livraison_stock_lot DROP FOREIGN KEY FK_802E9901274D3BD1');
        $this->addSql('DROP INDEX IDX_802E9901274D3BD1 ON livraison_stock_lot');
        $this->addSql('ALTER TABLE livraison_stock_lot DROP livraison_det_id, DROP lign_bl');
    }
}
