<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250127143052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison_observation (id INT AUTO_INCREMENT NOT NULL, livraison_id INT DEFAULT NULL, user_created_id INT DEFAULT NULL, observation LONGTEXT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, INDEX IDX_222A05E98E54FB25 (livraison_id), INDEX IDX_222A05E9F987D8A8 (user_created_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livraison_observation ADD CONSTRAINT FK_222A05E98E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_observation ADD CONSTRAINT FK_222A05E9F987D8A8 FOREIGN KEY (user_created_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livraison_observation DROP FOREIGN KEY FK_222A05E98E54FB25');
        $this->addSql('ALTER TABLE livraison_observation DROP FOREIGN KEY FK_222A05E9F987D8A8');
        $this->addSql('DROP TABLE livraison_observation');
    }
}
