<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207082151 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunt DROP FOREIGN KEY FK_364071D7C325A696');
        $this->addSql('CREATE TABLE emprunter (id INT AUTO_INCREMENT NOT NULL, emprunteur_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_E23B93FF0840037 (emprunteur_id), INDEX IDX_E23B93F37D925CB (livre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emprunteur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93FF0840037 FOREIGN KEY (emprunteur_id) REFERENCES emprunteur (id)');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93F37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('DROP TABLE abonne');
        $this->addSql('DROP TABLE emprunt');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunter DROP FOREIGN KEY FK_E23B93FF0840037');
        $this->addSql('CREATE TABLE abonne (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE emprunt (id INT AUTO_INCREMENT NOT NULL, abonne_id INT DEFAULT NULL, livre_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_364071D737D925CB (livre_id), INDEX IDX_364071D7C325A696 (abonne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('ALTER TABLE emprunt ADD CONSTRAINT FK_364071D7C325A696 FOREIGN KEY (abonne_id) REFERENCES abonne (id)');
        $this->addSql('DROP TABLE emprunter');
        $this->addSql('DROP TABLE emprunteur');
    }
}
