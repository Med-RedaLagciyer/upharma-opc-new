<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250121105637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E36BF700BD');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E36BF700BD FOREIGN KEY (status_id) REFERENCES livraison_status (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E36BF700BD');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E36BF700BD FOREIGN KEY (status_id) REFERENCES demande_status (id)');
    }
}
