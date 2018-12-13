<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181213175157 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network_admin CHANGE name name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE network_entity CHANGE name name VARCHAR(255) NOT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_impact CHANGE name name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_impact CHANGE name name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE network_admin CHANGE name name VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE network_entity CHANGE name name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE slug slug VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
