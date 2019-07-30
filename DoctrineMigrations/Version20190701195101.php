<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190701195101 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD is_discarded TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql("INSERT INTO `incident_state_action` (`slug`, `name`, `description`, `open`, `close`, `re_open`,`discard`) VALUES ('discard', 'Discard', 'Discard Incident', '0', '0', '0','1')");
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`, `mail_admin`, `mail_reporter`, `mail_assigned`, `mail_team`, `incident_state_action`) VALUES ('discarded-by-unattended', 'Discarded by unattended', '1', NOW(), NOW(), 'none', 'none', 'none', 'none', 'discard')");
        $this->addSql("update incident_priority set  unresponse_time=10080, unresolution_time=10080 where slug <>'high_high';");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP is_discarded');
    }
}
