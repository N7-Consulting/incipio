<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210724021853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Alumnus DROP FOREIGN KEY FK_215565EC4102CFC8');
        $this->addSql('ALTER TABLE Prospect DROP FOREIGN KEY FK_30B8EE2B4ED73C6D');
        $this->addSql('DROP TABLE SecteurActivite');
        $this->addSql('DROP INDEX IDX_215565EC4102CFC8 ON Alumnus');
        $this->addSql('ALTER TABLE Alumnus CHANGE secteuractuel_id secteurActuel INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_30B8EE2B4ED73C6D ON Prospect');
        $this->addSql('ALTER TABLE Prospect CHANGE secteuractivite_id secteurActivite INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SecteurActivite (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(127) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE Alumnus CHANGE secteuractuel secteurActuel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565EC4102CFC8 FOREIGN KEY (secteurActuel_id) REFERENCES SecteurActivite (id)');
        $this->addSql('CREATE INDEX IDX_215565EC4102CFC8 ON Alumnus (secteurActuel_id)');
        $this->addSql('ALTER TABLE Prospect CHANGE secteuractivite secteurActivite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Prospect ADD CONSTRAINT FK_30B8EE2B4ED73C6D FOREIGN KEY (secteurActivite_id) REFERENCES SecteurActivite (id)');
        $this->addSql('CREATE INDEX IDX_30B8EE2B4ED73C6D ON Prospect (secteurActivite_id)');
    }
}
