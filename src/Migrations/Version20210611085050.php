<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611085050 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Etude ADD CDC VARCHAR(255) DEFAULT NULL, ADD PC VARCHAR(255) DEFAULT NULL, ADD CE VARCHAR(255) DEFAULT NULL, ADD CCA VARCHAR(255) DEFAULT NULL, ADD BDC VARCHAR(255) DEFAULT NULL, ADD RM VARCHAR(255) DEFAULT NULL, ADD AVRM VARCHAR(255) DEFAULT NULL, ADD AVCE VARCHAR(255) DEFAULT NULL, ADD PVRI VARCHAR(255) DEFAULT NULL, ADD PVRF VARCHAR(255) DEFAULT NULL, ADD QS VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Etude DROP CDC, DROP PC, DROP CE, DROP CCA, DROP BDC, DROP RM, DROP AVRM, DROP AVCE, DROP PVRI, DROP PVRF, DROP QS');
    }
}
