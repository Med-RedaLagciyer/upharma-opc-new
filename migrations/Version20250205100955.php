<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250205100955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_activity (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, action VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created DATETIME DEFAULT NULL, page VARCHAR(255) DEFAULT NULL, INDEX IDX_4CF9ED5AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_status_logs (id INT AUTO_INCREMENT NOT NULL, livraison_id INT DEFAULT NULL, status_id INT DEFAULT NULL, user_created_id INT DEFAULT NULL, created DATETIME DEFAULT NULL, INDEX IDX_6192A25D8E54FB25 (livraison_id), INDEX IDX_6192A25D6BF700BD (status_id), INDEX IDX_6192A25DF987D8A8 (user_created_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_activity ADD CONSTRAINT FK_4CF9ED5AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_status_logs ADD CONSTRAINT FK_6192A25D8E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('ALTER TABLE user_status_logs ADD CONSTRAINT FK_6192A25D6BF700BD FOREIGN KEY (status_id) REFERENCES livraison_status (id)');
        $this->addSql('ALTER TABLE user_status_logs ADD CONSTRAINT FK_6192A25DF987D8A8 FOREIGN KEY (user_created_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_activity DROP FOREIGN KEY FK_4CF9ED5AA76ED395');
        $this->addSql('ALTER TABLE user_status_logs DROP FOREIGN KEY FK_6192A25D8E54FB25');
        $this->addSql('ALTER TABLE user_status_logs DROP FOREIGN KEY FK_6192A25D6BF700BD');
        $this->addSql('ALTER TABLE user_status_logs DROP FOREIGN KEY FK_6192A25DF987D8A8');
        $this->addSql('DROP TABLE user_activity');
        $this->addSql('DROP TABLE user_status_logs');
    }
}
