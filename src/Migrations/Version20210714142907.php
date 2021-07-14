<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714142907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Alumnus ADD personne_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565ECA21BD112 FOREIGN KEY (personne_id) REFERENCES Personne (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_215565ECA21BD112 ON Alumnus (personne_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Alumnus DROP FOREIGN KEY FK_215565ECA21BD112');
        $this->addSql('DROP INDEX UNIQ_215565ECA21BD112 ON Alumnus');
        $this->addSql('ALTER TABLE Alumnus DROP personne_id');
    }
}
