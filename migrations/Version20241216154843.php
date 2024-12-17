<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241216154843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, nom_menu VARCHAR(255) NOT NULL, prix_menu VARCHAR(255) NOT NULL, desponibilite TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_repat (menu_id INT NOT NULL, repat_id INT NOT NULL, INDEX IDX_A71BE777CCD7E912 (menu_id), INDEX IDX_A71BE77780F45213 (repat_id), PRIMARY KEY(menu_id, repat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repat (id INT AUTO_INCREMENT NOT NULL, nom_repat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, type VARCHAR(255) NOT NULL, ligne VARCHAR(255) NOT NULL, point_depart VARCHAR(255) DEFAULT NULL, destination VARCHAR(255) NOT NULL, horaire DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX IDX_2B5BA98C4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, matricule VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, capacite INT NOT NULL, statut VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu_repat ADD CONSTRAINT FK_A71BE777CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_repat ADD CONSTRAINT FK_A71BE77780F45213 FOREIGN KEY (repat_id) REFERENCES repat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE chambre DROP FOREIGN KEY FK_C509E4FF2B919A58');
        $this->addSql('ALTER TABLE demande_selection DROP FOREIGN KEY FK_E389F6022B919A58');
        $this->addSql('ALTER TABLE demande_selection DROP FOREIGN KEY FK_E389F6029B177F54');
        $this->addSql('ALTER TABLE resident DROP FOREIGN KEY FK_1D03DA062B919A58');
        $this->addSql('ALTER TABLE resident DROP FOREIGN KEY FK_1D03DA06BF396750');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE demande_selection');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE foyer');
        $this->addSql('DROP TABLE resident');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, foyer_id INT NOT NULL, numero VARCHAR(55) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, capacite INT NOT NULL, etat VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type_lit VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C509E4FF2B919A58 (foyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE demande_selection (id INT AUTO_INCREMENT NOT NULL, chambre_id INT NOT NULL, foyer_id INT NOT NULL, date_demande DATETIME NOT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_E389F6029B177F54 (chambre_id), INDEX IDX_E389F6022B919A58 (foyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, discr VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE foyer (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(70) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, adresse VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, genre VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, gouvernorat VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, capacite INT NOT NULL, status VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE resident (id INT NOT NULL, foyer_id INT NOT NULL, date_entree DATE NOT NULL, date_sortie DATE DEFAULT NULL, INDEX IDX_1D03DA062B919A58 (foyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE chambre ADD CONSTRAINT FK_C509E4FF2B919A58 FOREIGN KEY (foyer_id) REFERENCES foyer (id)');
        $this->addSql('ALTER TABLE demande_selection ADD CONSTRAINT FK_E389F6022B919A58 FOREIGN KEY (foyer_id) REFERENCES foyer (id)');
        $this->addSql('ALTER TABLE demande_selection ADD CONSTRAINT FK_E389F6029B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE resident ADD CONSTRAINT FK_1D03DA062B919A58 FOREIGN KEY (foyer_id) REFERENCES foyer (id)');
        $this->addSql('ALTER TABLE resident ADD CONSTRAINT FK_1D03DA06BF396750 FOREIGN KEY (id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_repat DROP FOREIGN KEY FK_A71BE777CCD7E912');
        $this->addSql('ALTER TABLE menu_repat DROP FOREIGN KEY FK_A71BE77780F45213');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C4A4A3511');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_repat');
        $this->addSql('DROP TABLE repat');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE vehicule');
    }
}
