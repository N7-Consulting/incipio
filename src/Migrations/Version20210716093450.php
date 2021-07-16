<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716093450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Prospect DROP FOREIGN KEY FK_30B8EE2B4102CFC8');
        $this->addSql('DROP INDEX IDX_30B8EE2B4102CFC8 ON Prospect');
        $this->addSql('ALTER TABLE Prospect CHANGE secteuractuel_id secteurActivite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Prospect ADD CONSTRAINT FK_30B8EE2B4ED73C6D FOREIGN KEY (secteurActivite_id) REFERENCES SecteurActivite (id)');
        $this->addSql('CREATE INDEX IDX_30B8EE2B4ED73C6D ON Prospect (secteurActivite_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Prospect DROP FOREIGN KEY FK_30B8EE2B4ED73C6D');
        $this->addSql('DROP INDEX IDX_30B8EE2B4ED73C6D ON Prospect');
        $this->addSql('ALTER TABLE Prospect CHANGE secteuractivite_id secteurActuel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Prospect ADD CONSTRAINT FK_30B8EE2B4102CFC8 FOREIGN KEY (secteurActuel_id) REFERENCES SecteurActivite (id)');
        $this->addSql('CREATE INDEX IDX_30B8EE2B4102CFC8 ON Prospect (secteurActuel_id)');
    }
}
