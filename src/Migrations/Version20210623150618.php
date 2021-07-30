<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210623150618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Cca (id INT AUTO_INCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL, signataire1_id INT DEFAULT NULL, signataire2_id INT DEFAULT NULL, prospect_id INT NOT NULL, version INT DEFAULT NULL, redige TINYINT(1) DEFAULT NULL, relu TINYINT(1) DEFAULT NULL, spt1 TINYINT(1) DEFAULT NULL, spt2 TINYINT(1) DEFAULT NULL, dateSignature DATETIME DEFAULT NULL, envoye TINYINT(1) DEFAULT NULL, receptionne TINYINT(1) DEFAULT NULL, generer INT DEFAULT NULL, dateFin DATE NOT NULL, UNIQUE INDEX UNIQ_F9F88321E2904019 (thread_id), INDEX IDX_F9F88321C71184C3 (signataire1_id), INDEX IDX_F9F88321D5A42B2D (signataire2_id), INDEX IDX_F9F88321D182060A (prospect_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321C71184C3 FOREIGN KEY (signataire1_id) REFERENCES Personne (id)');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321D5A42B2D FOREIGN KEY (signataire2_id) REFERENCES Personne (id)');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321D182060A FOREIGN KEY (prospect_id) REFERENCES Prospect (id)');
        $this->addSql('ALTER TABLE Etude ADD cca_id INT DEFAULT NULL, ADD ccaActive TINYINT(1) DEFAULT NULL, DROP cca');
        $this->addSql('ALTER TABLE Etude ADD CONSTRAINT FK_DC1F8620FBAA5D8E FOREIGN KEY (cca_id) REFERENCES Cca (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DC1F8620FBAA5D8E ON Etude (cca_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Etude DROP FOREIGN KEY FK_DC1F8620FBAA5D8E');
        $this->addSql('DROP TABLE Cca');
        $this->addSql('DROP INDEX UNIQ_DC1F862028DF9AB0 ON Etude');
        $this->addSql('DROP INDEX IDX_DC1F8620FBAA5D8E ON Etude');
        $this->addSql('ALTER TABLE Etude ADD cca VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, DROP cca_id, DROP ccaActive');
    }
}
