<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210907064258 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Etude DROP FOREIGN KEY FK_DC1F8620FBAA5D8E');
        $this->addSql('ALTER TABLE RelatedDocument DROP FOREIGN KEY FK_E28BFD666893B9E9');
        $this->addSql('ALTER TABLE RelatedDocument DROP FOREIGN KEY FK_E28BFD66A55629DC');
        $this->addSql('CREATE TABLE Alumnus (id INT AUTO_INCREMENT NOT NULL, personne_id INT DEFAULT NULL, commentaire VARCHAR(255) DEFAULT NULL, lienLinkedIn VARCHAR(255) DEFAULT NULL, posteActuel VARCHAR(255) DEFAULT NULL, secteurActuel INT DEFAULT NULL, UNIQUE INDEX UNIQ_215565ECA21BD112 (personne_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AlumnusContact (id INT AUTO_INCREMENT NOT NULL, alumnus_id INT NOT NULL, date DATETIME DEFAULT NULL, objet VARCHAR(255) DEFAULT NULL, contenu VARCHAR(255) DEFAULT NULL, moyenContact VARCHAR(255) DEFAULT NULL, faitPar_id INT NOT NULL, INDEX IDX_F79B05CE8A6FD59C (alumnus_id), INDEX IDX_F79B05CE5302E431 (faitPar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565ECA21BD112 FOREIGN KEY (personne_id) REFERENCES Membre (id)');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE8A6FD59C FOREIGN KEY (alumnus_id) REFERENCES Alumnus (id)');
        $this->addSql('ALTER TABLE AlumnusContact ADD CONSTRAINT FK_F79B05CE5302E431 FOREIGN KEY (faitPar_id) REFERENCES Personne (id)');
        $this->addSql('DROP TABLE Cca');
        $this->addSql('DROP TABLE Passation');
        $this->addSql('DROP TABLE Processus');
        $this->addSql('ALTER TABLE Ap ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Ap ADD CONSTRAINT FK_F8BE1D87E2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F8BE1D87E2904019 ON Ap (thread_id)');
        $this->addSql('ALTER TABLE Av ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Av ADD CONSTRAINT FK_11DDB8B2E2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11DDB8B2E2904019 ON Av (thread_id)');
        $this->addSql('ALTER TABLE AvMission ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE AvMission ADD CONSTRAINT FK_87698F23E2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_87698F23E2904019 ON AvMission (thread_id)');
        $this->addSql('ALTER TABLE Cc ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Cc ADD CONSTRAINT FK_4E363EDBE2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E363EDBE2904019 ON Cc (thread_id)');
        $this->addSql('ALTER TABLE Ce ADD thread_id VARCHAR(255) DEFAULT NULL, DROP type');
        $this->addSql('ALTER TABLE Ce ADD CONSTRAINT FK_A7559BEEE2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7559BEEE2904019 ON Ce (thread_id)');
        $this->addSql('DROP INDEX IDX_DC1F8620FBAA5D8E ON Etude');
        $this->addSql('ALTER TABLE Etude DROP cca_id, DROP auditCommentaires, DROP ccaActive');
        $this->addSql('ALTER TABLE Formation CHANGE categorie categorie LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE Mission ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Mission ADD CONSTRAINT FK_5FDACBA0E2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FDACBA0E2904019 ON Mission (thread_id)');
        $this->addSql('ALTER TABLE ProcesVerbal ADD thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ProcesVerbal ADD CONSTRAINT FK_D8EBE2BFE2904019 FOREIGN KEY (thread_id) REFERENCES Thread (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D8EBE2BFE2904019 ON ProcesVerbal (thread_id)');
        $this->addSql('DROP INDEX IDX_E28BFD666893B9E9 ON RelatedDocument');
        $this->addSql('DROP INDEX IDX_E28BFD66A55629DC ON RelatedDocument');
        $this->addSql('ALTER TABLE RelatedDocument DROP processus_id, DROP passation_id');
        $this->addSql('ALTER TABLE RepartitionJEH DROP FOREIGN KEY FK_5E061BA899091188');
        $this->addSql('DROP INDEX IDX_5E061BA899091188 ON RepartitionJEH');
        $this->addSql('ALTER TABLE RepartitionJEH DROP phase_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE AlumnusContact DROP FOREIGN KEY FK_F79B05CE8A6FD59C');
        $this->addSql('CREATE TABLE Cca (id INT AUTO_INCREMENT NOT NULL, signataire1_id INT DEFAULT NULL, signataire2_id INT DEFAULT NULL, prospect_id INT NOT NULL, version INT DEFAULT NULL, redige TINYINT(1) DEFAULT NULL, relu TINYINT(1) DEFAULT NULL, spt1 TINYINT(1) DEFAULT NULL, spt2 TINYINT(1) DEFAULT NULL, dateSignature DATETIME DEFAULT NULL, envoye TINYINT(1) DEFAULT NULL, receptionne TINYINT(1) DEFAULT NULL, generer INT DEFAULT NULL, dateFin DATE NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_F9F883216C6E55B5 (nom), INDEX IDX_F9F88321D5A42B2D (signataire2_id), INDEX IDX_F9F88321D182060A (prospect_id), INDEX IDX_F9F88321C71184C3 (signataire1_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Passation (id INT AUTO_INCREMENT NOT NULL, categorie INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Processus (id INT AUTO_INCREMENT NOT NULL, pilote_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_6C1B0EBEF510AAE9 (pilote_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321C71184C3 FOREIGN KEY (signataire1_id) REFERENCES Personne (id)');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321D182060A FOREIGN KEY (prospect_id) REFERENCES Prospect (id)');
        $this->addSql('ALTER TABLE Cca ADD CONSTRAINT FK_F9F88321D5A42B2D FOREIGN KEY (signataire2_id) REFERENCES Personne (id)');
        $this->addSql('ALTER TABLE Processus ADD CONSTRAINT FK_6C1B0EBEF510AAE9 FOREIGN KEY (pilote_id) REFERENCES Personne (id)');
        $this->addSql('DROP TABLE Alumnus');
        $this->addSql('DROP TABLE AlumnusContact');
        $this->addSql('ALTER TABLE Ap DROP FOREIGN KEY FK_F8BE1D87E2904019');
        $this->addSql('DROP INDEX UNIQ_F8BE1D87E2904019 ON Ap');
        $this->addSql('ALTER TABLE Ap DROP thread_id');
        $this->addSql('ALTER TABLE Av DROP FOREIGN KEY FK_11DDB8B2E2904019');
        $this->addSql('DROP INDEX UNIQ_11DDB8B2E2904019 ON Av');
        $this->addSql('ALTER TABLE Av DROP thread_id');
        $this->addSql('ALTER TABLE AvMission DROP FOREIGN KEY FK_87698F23E2904019');
        $this->addSql('DROP INDEX UNIQ_87698F23E2904019 ON AvMission');
        $this->addSql('ALTER TABLE AvMission DROP thread_id');
        $this->addSql('ALTER TABLE Cc DROP FOREIGN KEY FK_4E363EDBE2904019');
        $this->addSql('DROP INDEX UNIQ_4E363EDBE2904019 ON Cc');
        $this->addSql('ALTER TABLE Cc DROP thread_id');
        $this->addSql('ALTER TABLE Ce DROP FOREIGN KEY FK_A7559BEEE2904019');
        $this->addSql('DROP INDEX UNIQ_A7559BEEE2904019 ON Ce');
        $this->addSql('ALTER TABLE Ce ADD type SMALLINT NOT NULL, DROP thread_id');
        $this->addSql('ALTER TABLE Etude ADD cca_id INT DEFAULT NULL, ADD auditCommentaires LONGTEXT CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD ccaActive TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE Etude ADD CONSTRAINT FK_DC1F8620FBAA5D8E FOREIGN KEY (cca_id) REFERENCES Cca (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_DC1F8620FBAA5D8E ON Etude (cca_id)');
        $this->addSql('ALTER TABLE Formation CHANGE categorie categorie INT NOT NULL');
        $this->addSql('ALTER TABLE Mission DROP FOREIGN KEY FK_5FDACBA0E2904019');
        $this->addSql('DROP INDEX UNIQ_5FDACBA0E2904019 ON Mission');
        $this->addSql('ALTER TABLE Mission DROP thread_id');
        $this->addSql('ALTER TABLE ProcesVerbal DROP FOREIGN KEY FK_D8EBE2BFE2904019');
        $this->addSql('DROP INDEX UNIQ_D8EBE2BFE2904019 ON ProcesVerbal');
        $this->addSql('ALTER TABLE ProcesVerbal DROP thread_id');
        $this->addSql('ALTER TABLE RelatedDocument ADD processus_id INT DEFAULT NULL, ADD passation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE RelatedDocument ADD CONSTRAINT FK_E28BFD666893B9E9 FOREIGN KEY (passation_id) REFERENCES Passation (id)');
        $this->addSql('ALTER TABLE RelatedDocument ADD CONSTRAINT FK_E28BFD66A55629DC FOREIGN KEY (processus_id) REFERENCES Processus (id)');
        $this->addSql('CREATE INDEX IDX_E28BFD666893B9E9 ON RelatedDocument (passation_id)');
        $this->addSql('CREATE INDEX IDX_E28BFD66A55629DC ON RelatedDocument (processus_id)');
        $this->addSql('ALTER TABLE RepartitionJEH ADD phase_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE RepartitionJEH ADD CONSTRAINT FK_5E061BA899091188 FOREIGN KEY (phase_id) REFERENCES Phase (id)');
        $this->addSql('CREATE INDEX IDX_5E061BA899091188 ON RepartitionJEH (phase_id)');
    }
}
