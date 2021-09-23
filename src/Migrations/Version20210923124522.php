<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Add Alumnus table to define an alumnus: one member with more information
 * Add AlumnusContact table to record contacts with alumni.
 */
final class Version20210923124522 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Alumnus (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, lienLinkedIn VARCHAR(255) DEFAULT NULL, posteActuel VARCHAR(255) DEFAULT NULL, secteurActuel INT DEFAULT NULL, UNIQUE INDEX UNIQ_215565ECA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AlumnusContact (id INT AUTO_INCREMENT NOT NULL, alumnus_id INT NOT NULL, date DATETIME DEFAULT NULL, objet VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, moyenContact VARCHAR(255) DEFAULT NULL, faitPar_id INT NOT NULL, INDEX IDX_F79B05CE8A6FD59C (alumnus_id), INDEX IDX_F79B05CE5302E431 (faitPar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565ECA21BD112 FOREIGN KEY (personne_id) REFERENCES Membre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE8A6FD59C FOREIGN KEY (alumnus_id) REFERENCES Alumnus (id)');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE5302E431 FOREIGN KEY (faitPar_id) REFERENCES Personne (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE AlumnusContact DROP FOREIGN KEY FK_F79B05CE8A6FD59C');
        $this->addSql('DROP TABLE Alumnus');
        $this->addSql('DROP TABLE AlumnusContact');
    }
}
