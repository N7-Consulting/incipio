<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<< HEAD
final class Version20210613185604 extends AbstractMigration
=======
<<<<<<< HEAD:src/Migrations/Version20210612021515.php
final class Version20210612021515 extends AbstractMigration
=======
final class Version20210613185604 extends AbstractMigration
>>>>>>> document:src/Migrations/Version20210613185604.php
>>>>>>> document
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

<<<<<<< HEAD
        $this->addSql('ALTER TABLE Etude ADD cdc VARCHAR(255) DEFAULT NULL, ADD pc VARCHAR(255) DEFAULT NULL, ADD cca VARCHAR(255) DEFAULT NULL, ADD bdc VARCHAR(255) DEFAULT NULL, ADD qs VARCHAR(255) DEFAULT NULL');
=======
<<<<<<< HEAD:src/Migrations/Version20210612021515.php
        $this->addSql('CREATE TABLE Processus (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, pilote VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
=======
        $this->addSql('ALTER TABLE Etude ADD cdc VARCHAR(255) DEFAULT NULL, ADD pc VARCHAR(255) DEFAULT NULL, ADD cca VARCHAR(255) DEFAULT NULL, ADD bdc VARCHAR(255) DEFAULT NULL, ADD qs VARCHAR(255) DEFAULT NULL');
>>>>>>> document:src/Migrations/Version20210613185604.php
>>>>>>> document
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

<<<<<<< HEAD
        $this->addSql('ALTER TABLE Etude DROP cdc, DROP pc, DROP cca, DROP bdc, DROP qs');
=======
<<<<<<< HEAD:src/Migrations/Version20210612021515.php
        $this->addSql('DROP TABLE Processus');
=======
        $this->addSql('ALTER TABLE Etude DROP cdc, DROP pc, DROP cca, DROP bdc, DROP qs');
>>>>>>> document:src/Migrations/Version20210613185604.php
>>>>>>> document
    }
}
