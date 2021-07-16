<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716082938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Alumnus ADD secteurActuel_id INT DEFAULT NULL, DROP secteurActuel');
        $this->addSql('ALTER TABLE Alumnus ADD CONSTRAINT FK_215565EC4102CFC8 FOREIGN KEY (secteurActuel_id) REFERENCES SecteurActivite (id)');
        $this->addSql('CREATE INDEX IDX_215565EC4102CFC8 ON Alumnus (secteurActuel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Alumnus DROP FOREIGN KEY FK_215565EC4102CFC8');
        $this->addSql('DROP INDEX IDX_215565EC4102CFC8 ON Alumnus');
        $this->addSql('ALTER TABLE Alumnus ADD secteurActuel VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP secteurActuel_id');
    }
}
