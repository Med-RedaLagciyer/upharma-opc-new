<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116113550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande_type (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_status (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_stock_cab (id INT AUTO_INCREMENT NOT NULL, demandeur_id INT DEFAULT NULL, recepteur_id INT DEFAULT NULL, client_id INT DEFAULT NULL, status_id INT DEFAULT NULL, commande_type_id INT DEFAULT NULL, type_op_id INT DEFAULT NULL, di VARCHAR(255) DEFAULT NULL, ipp VARCHAR(255) DEFAULT NULL, patient VARCHAR(255) DEFAULT NULL, tipo_facturac VARCHAR(255) DEFAULT NULL, dossier_patient VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, observation VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, ref_doc_asso VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_69C8B9BA95A6EE59 (demandeur_id), INDEX IDX_69C8B9BA3B49782D (recepteur_id), INDEX IDX_69C8B9BA19EB6921 (client_id), INDEX IDX_69C8B9BA6BF700BD (status_id), INDEX IDX_69C8B9BA33F7FE33 (commande_type_id), INDEX IDX_69C8B9BA21732CC8 (type_op_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_stock_det (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, demande_cab_id INT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, qte DOUBLE PRECISION DEFAULT NULL, qt_livre DOUBLE PRECISION DEFAULT NULL, conditionnement VARCHAR(255) DEFAULT NULL, conditionnement_livre VARCHAR(255) DEFAULT NULL, observation VARCHAR(255) DEFAULT NULL, lot VARCHAR(255) DEFAULT NULL, date_peremption DATETIME DEFAULT NULL, prix_vente_ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_achat_ht DOUBLE PRECISION DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_FC3FDF6A7294869C (article_id), INDEX IDX_FC3FDF6AD19BE7EF (demande_cab_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande_type_op (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison_stock_cab (id INT AUTO_INCREMENT NOT NULL, demande_id INT DEFAULT NULL, status_id INT DEFAULT NULL, user_created_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, urgent DOUBLE PRECISION DEFAULT NULL, mh_total DOUBLE PRECISION DEFAULT NULL, mr_total DOUBLE PRECISION DEFAULT NULL, mtva_total DOUBLE PRECISION DEFAULT NULL, mtt_total DOUBLE PRECISION DEFAULT NULL, date DATETIME DEFAULT NULL, active TINYINT(1) DEFAULT NULL, print VARCHAR(255) DEFAULT NULL, valide TINYINT(1) DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_E12546E380E95E18 (demande_id), INDEX IDX_E12546E36BF700BD (status_id), INDEX IDX_E12546E3F987D8A8 (user_created_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison_stock_det (id INT AUTO_INCREMENT NOT NULL, livraison_id INT DEFAULT NULL, article_id INT DEFAULT NULL, quantity DOUBLE PRECISION DEFAULT NULL, observation VARCHAR(255) DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_74D220338E54FB25 (livraison_id), INDEX IDX_74D220337294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livraison_stock_details (id INT AUTO_INCREMENT NOT NULL, livraison_det_id INT DEFAULT NULL, lot VARCHAR(255) DEFAULT NULL, date_peremption DATE DEFAULT NULL, quantite INT DEFAULT NULL, quantite_retour DOUBLE PRECISION DEFAULT NULL, prix_vente_ttc DOUBLE PRECISION DEFAULT NULL, tva DOUBLE PRECISION DEFAULT NULL, prix_achat_ht DOUBLE PRECISION DEFAULT NULL, mh DOUBLE PRECISION DEFAULT NULL, mr DOUBLE PRECISION DEFAULT NULL, mtva DOUBLE PRECISION DEFAULT NULL, mtt DOUBLE PRECISION DEFAULT NULL, date_sys DATETIME DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, valeur_a DOUBLE PRECISION DEFAULT NULL, merge DOUBLE PRECISION DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_DB29B8EF274D3BD1 (livraison_det_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdossier (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(255) DEFAULT NULL, abreviation2 VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, nom_dossier VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, externe TINYINT(1) DEFAULT NULL, prefix VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uarticle (id INT AUTO_INCREMENT NOT NULL, famille_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, stock_min INT DEFAULT NULL, stock_max INT DEFAULT NULL, code_barre VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, id_access INT DEFAULT NULL, INDEX IDX_1EC4918597A77B84 (famille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ufamille (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uppartenaire (id INT AUTO_INCREMENT NOT NULL, uppartenaire_ty_id INT DEFAULT NULL, code VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, societe VARCHAR(255) DEFAULT NULL, adresse LONGTEXT DEFAULT NULL, pays VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, tel1 VARCHAR(255) DEFAULT NULL, tel2 VARCHAR(255) DEFAULT NULL, tel3 VARCHAR(255) DEFAULT NULL, fax1 VARCHAR(255) DEFAULT NULL, fax2 VARCHAR(255) DEFAULT NULL, mail1 VARCHAR(255) DEFAULT NULL, mail2 VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, ice VARCHAR(255) DEFAULT NULL, INDEX IDX_E86BA97D4E22BC58 (uppartenaire_ty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE uppartenaire_ty (id INT AUTO_INCREMENT NOT NULL, abreviation VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE us_module (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, prefix VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, ordre INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE us_operation (id INT AUTO_INCREMENT NOT NULL, sous_module_id INT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, class_tag VARCHAR(255) DEFAULT NULL, id_tag VARCHAR(255) DEFAULT NULL, ordre INT DEFAULT NULL, align TINYINT(1) DEFAULT NULL, INDEX IDX_176B6B7FB4CB5EDE (sous_module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE us_operation_user (us_operation_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_61201196585E0F6 (us_operation_id), INDEX IDX_6120119A76ED395 (user_id), PRIMARY KEY(us_operation_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE us_sous_module (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, designation VARCHAR(255) DEFAULT NULL, prefix VARCHAR(255) DEFAULT NULL, ordre INT NOT NULL, INDEX IDX_411A14EBAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, enable TINYINT(1) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, created DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA95A6EE59 FOREIGN KEY (demandeur_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA3B49782D FOREIGN KEY (recepteur_id) REFERENCES pdossier (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA19EB6921 FOREIGN KEY (client_id) REFERENCES uppartenaire (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA6BF700BD FOREIGN KEY (status_id) REFERENCES demande_status (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA33F7FE33 FOREIGN KEY (commande_type_id) REFERENCES commande_type (id)');
        $this->addSql('ALTER TABLE demande_stock_cab ADD CONSTRAINT FK_69C8B9BA21732CC8 FOREIGN KEY (type_op_id) REFERENCES demande_type_op (id)');
        $this->addSql('ALTER TABLE demande_stock_det ADD CONSTRAINT FK_FC3FDF6A7294869C FOREIGN KEY (article_id) REFERENCES uarticle (id)');
        $this->addSql('ALTER TABLE demande_stock_det ADD CONSTRAINT FK_FC3FDF6AD19BE7EF FOREIGN KEY (demande_cab_id) REFERENCES demande_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E380E95E18 FOREIGN KEY (demande_id) REFERENCES demande_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E36BF700BD FOREIGN KEY (status_id) REFERENCES demande_status (id)');
        $this->addSql('ALTER TABLE livraison_stock_cab ADD CONSTRAINT FK_E12546E3F987D8A8 FOREIGN KEY (user_created_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livraison_stock_det ADD CONSTRAINT FK_74D220338E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison_stock_cab (id)');
        $this->addSql('ALTER TABLE livraison_stock_det ADD CONSTRAINT FK_74D220337294869C FOREIGN KEY (article_id) REFERENCES uarticle (id)');
        $this->addSql('ALTER TABLE livraison_stock_details ADD CONSTRAINT FK_DB29B8EF274D3BD1 FOREIGN KEY (livraison_det_id) REFERENCES livraison_stock_det (id)');
        $this->addSql('ALTER TABLE uarticle ADD CONSTRAINT FK_1EC4918597A77B84 FOREIGN KEY (famille_id) REFERENCES ufamille (id)');
        $this->addSql('ALTER TABLE uppartenaire ADD CONSTRAINT FK_E86BA97D4E22BC58 FOREIGN KEY (uppartenaire_ty_id) REFERENCES uppartenaire_ty (id)');
        $this->addSql('ALTER TABLE us_operation ADD CONSTRAINT FK_176B6B7FB4CB5EDE FOREIGN KEY (sous_module_id) REFERENCES us_sous_module (id)');
        $this->addSql('ALTER TABLE us_operation_user ADD CONSTRAINT FK_61201196585E0F6 FOREIGN KEY (us_operation_id) REFERENCES us_operation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE us_operation_user ADD CONSTRAINT FK_6120119A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE us_sous_module ADD CONSTRAINT FK_411A14EBAFC2B591 FOREIGN KEY (module_id) REFERENCES us_module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA95A6EE59');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA3B49782D');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA19EB6921');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA6BF700BD');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA33F7FE33');
        $this->addSql('ALTER TABLE demande_stock_cab DROP FOREIGN KEY FK_69C8B9BA21732CC8');
        $this->addSql('ALTER TABLE demande_stock_det DROP FOREIGN KEY FK_FC3FDF6A7294869C');
        $this->addSql('ALTER TABLE demande_stock_det DROP FOREIGN KEY FK_FC3FDF6AD19BE7EF');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E380E95E18');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E36BF700BD');
        $this->addSql('ALTER TABLE livraison_stock_cab DROP FOREIGN KEY FK_E12546E3F987D8A8');
        $this->addSql('ALTER TABLE livraison_stock_det DROP FOREIGN KEY FK_74D220338E54FB25');
        $this->addSql('ALTER TABLE livraison_stock_det DROP FOREIGN KEY FK_74D220337294869C');
        $this->addSql('ALTER TABLE livraison_stock_details DROP FOREIGN KEY FK_DB29B8EF274D3BD1');
        $this->addSql('ALTER TABLE uarticle DROP FOREIGN KEY FK_1EC4918597A77B84');
        $this->addSql('ALTER TABLE uppartenaire DROP FOREIGN KEY FK_E86BA97D4E22BC58');
        $this->addSql('ALTER TABLE us_operation DROP FOREIGN KEY FK_176B6B7FB4CB5EDE');
        $this->addSql('ALTER TABLE us_operation_user DROP FOREIGN KEY FK_61201196585E0F6');
        $this->addSql('ALTER TABLE us_operation_user DROP FOREIGN KEY FK_6120119A76ED395');
        $this->addSql('ALTER TABLE us_sous_module DROP FOREIGN KEY FK_411A14EBAFC2B591');
        $this->addSql('DROP TABLE commande_type');
        $this->addSql('DROP TABLE demande_status');
        $this->addSql('DROP TABLE demande_stock_cab');
        $this->addSql('DROP TABLE demande_stock_det');
        $this->addSql('DROP TABLE demande_type_op');
        $this->addSql('DROP TABLE livraison_stock_cab');
        $this->addSql('DROP TABLE livraison_stock_det');
        $this->addSql('DROP TABLE livraison_stock_details');
        $this->addSql('DROP TABLE pdossier');
        $this->addSql('DROP TABLE uarticle');
        $this->addSql('DROP TABLE ufamille');
        $this->addSql('DROP TABLE uppartenaire');
        $this->addSql('DROP TABLE uppartenaire_ty');
        $this->addSql('DROP TABLE us_module');
        $this->addSql('DROP TABLE us_operation');
        $this->addSql('DROP TABLE us_operation_user');
        $this->addSql('DROP TABLE us_sous_module');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
