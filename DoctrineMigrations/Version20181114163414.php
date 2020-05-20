<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181114163414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision ADD auto_saved TINYINT(1) NOT NULL DEFAULT  0, ADD is_active TINYINT(1) NOT NULL DEFAULT 1, DROP autoSaved, CHANGE created_at created_at DATETIME NOT NULL DEFAULT NOW(), CHANGE updated_at updated_at DATETIME NOT NULL DEFAULT NOW()');
        $this->addSql("INSERT INTO incident_decision (`type`, `feed`, `impact`, `urgency`, `tlp`, `state`,`is_active`) VALUES ('undefined', 'undefined', 'low', 'low', 'green', 'undefined',1)");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision ADD autoSaved TINYINT(1) DEFAULT NULL, DROP auto_saved, DROP is_active, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
