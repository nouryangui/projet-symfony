<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201213200449 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunter DROP FOREIGN KEY FK_E23B93FF0840037');
        $this->addSql('DROP INDEX IDX_E23B93FF0840037 ON emprunter');
        $this->addSql('ALTER TABLE emprunter CHANGE emprunteur_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E23B93FA76ED395 ON emprunter (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emprunter DROP FOREIGN KEY FK_E23B93FA76ED395');
        $this->addSql('DROP INDEX IDX_E23B93FA76ED395 ON emprunter');
        $this->addSql('ALTER TABLE emprunter CHANGE user_id emprunteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunter ADD CONSTRAINT FK_E23B93FF0840037 FOREIGN KEY (emprunteur_id) REFERENCES emprunteur (id)');
        $this->addSql('CREATE INDEX IDX_E23B93FF0840037 ON emprunter (emprunteur_id)');
    }
}
