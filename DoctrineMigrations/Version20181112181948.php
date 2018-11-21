<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181112181948 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident_decision ADD network INT DEFAULT NULL, ADD autoSaved TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B608487BC FOREIGN KEY (network) REFERENCES network (id)');
        $this->addSql('CREATE INDEX IDX_7C69DA3B608487BC ON incident_decision (network)');
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`) VALUES ('undefined', 'Undefined', '1', NOW(), NOW())");
        $this->addSql("UPDATE incident_urgency SET `slug`='high' WHERE `slug`='High'");
        $this->addSql("UPDATE incident_urgency SET `slug`='low' WHERE `slug`='Low'");
        $this->addSql("UPDATE incident_urgency SET `slug`='medium' WHERE `slug`='Medium'");
        $this->addSql("INSERT INTO incident_type (`slug`, `name`, `is_active`, `created_at`,`updated_at`) VALUES ('undefined', 'Undefined', '1', NOW(),NOW())");
        $this->addSql("INSERT INTO incident_feed (`slug`, `name`, `is_active`, `created_at`, `updated_at`) VALUES ('undefined', 'Undefined', '1', NOW(),NOW())");
        $this->addSql("INSERT INTO incident_decision (`type`, `feed`, `impact`, `urgency`, `tlp`, `state`) VALUES ('undefined', 'undefined', 'low', 'low', 'green', 'undefined')");


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B608487BC');
        $this->addSql('DROP INDEX IDX_7C69DA3B608487BC ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision DROP network, DROP autoSaved');
    }
}
