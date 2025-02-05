<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126132425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bordereaux_validation (id INT AUTO_INCREMENT NOT NULL, user_created_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, INDEX IDX_51700EDAF987D8A8 (user_created_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bordereaux_validation ADD CONSTRAINT FK_51700EDAF987D8A8 FOREIGN KEY (user_created_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD user_valider_id INT DEFAULT NULL, ADD bordereaux_validation_id INT DEFAULT NULL, ADD date_validation DATETIME DEFAULT NULL, CHANGE valide is_valide TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E3F749B324 FOREIGN KEY (user_valider_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E328D92935 FOREIGN KEY (bordereaux_validation_id) REFERENCES bordereaux_validation (id)');
        $this->addSql('CREATE INDEX IDX_E12546E3F749B324 ON livraison_stock_cab (user_valider_id)');
        $this->addSql('CREATE INDEX IDX_E12546E328D92935 ON livraison_stock_cab (bordereaux_validation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E328D92935');
        $this->addSql('ALTER TABLE bordereaux_validation DROP FOREIGN KEY FK_51700EDAF987D8A8');
        $this->addSql('DROP TABLE bordereaux_validation');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E3F749B324');
        $this->addSql('DROP INDEX IDX_E12546E3F749B324 ON livraison_stock_cab');
        $this->addSql('DROP INDEX IDX_E12546E328D92935 ON livraison_stock_cab');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP user_valider_id, DROP bordereaux_validation_id, DROP date_validation, CHANGE is_valide valide TINYINT(1) DEFAULT NULL');
    }
}
