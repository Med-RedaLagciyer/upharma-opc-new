<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117100129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_stock_cab ADD antenne_demandeur_id INT DEFAULT NULL, ADD antenne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA81B5293C FOREIGN KEY (antenne_demandeur_id) REFERENCES uantenne (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA399E1D33 FOREIGN KEY (antenne_id) REFERENCES uantenne (id)');
        $this->addSql('CREATE INDEX IDX_69C8B9BA81B5293C ON demande_stock_cab (antenne_demandeur_id)');
        $this->addSql('CREATE INDEX IDX_69C8B9BA399E1D33 ON demande_stock_cab (antenne_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA81B5293C');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA399E1D33');
        $this->addSql('DROP INDEX IDX_69C8B9BA81B5293C ON demande_stock_cab');
        $this->addSql('DROP INDEX IDX_69C8B9BA399E1D33 ON demande_stock_cab');
        $this->addSql('ALTER TABLE demande_stock_cab DROP antenne_demandeur_id, DROP antenne_id');
    }
}
