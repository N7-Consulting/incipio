<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210729171925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Membre DROP FOREIGN KEY FK_F118FE1F8A6FD59C');
        $this->addSql('DROP INDEX UNIQ_F118FE1F8A6FD59C ON Membre');
        $this->addSql('ALTER TABLE Membre DROP alumnus_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Membre ADD alumnus_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Membre ADD CONSTRAINT FK_F118FE1F8A6FD59C FOREIGN KEY (alumnus_id) REFERENCES Alumnus (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F118FE1F8A6FD59C ON Membre (alumnus_id)');
    }
}
