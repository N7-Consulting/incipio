<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716075510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SecteurActivite (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(127) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Alumnus DROP FOREIGN KEY FK_215565ECA21BD112');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565ECA21BD112 FOREIGN KEY (personne_id) REFERENCES Membre (id)');
        $this->addSql('ALTER TABLE AlumnusContact DROP FOREIGN KEY FK_F79B05CE8A6FD59C');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE8A6FD59C FOREIGN KEY (alumnus_id) REFERENCES Alumnus (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE SecteurActivite');
        $this->addSql('ALTER TABLE Alumnus DROP FOREIGN KEY FK_215565ECA21BD112');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565ECA21BD112 FOREIGN KEY (personne_id) REFERENCES Personne (id)');
        $this->addSql('ALTER TABLE AlumnusContact DROP FOREIGN KEY FK_F79B05CE8A6FD59C');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE8A6FD59C FOREIGN KEY (alumnus_id) REFERENCES Personne (id)');
    }
}
