<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190627174812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_priority ADD unresponse_time INT NOT NULL, ADD unresolution_time INT NOT NULL');
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`,  `incident_state_behavior`) VALUES ('closed_by_unresolved', 'Closed by unresolved', '1', NOW(), NOW(),  'close')");
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`, `incident_state_behavior`) VALUES ('closed_by_unsolved', 'Closed by unsolved', '1', NOW(), NOW(),  'close')");
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`,  `incident_state_behavior`) VALUES ('closed_by_unattended', 'Closed by unattended', '1', NOW(), NOW(), 'close')");
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`, `incident_state_behavior`) VALUES ('discarded_by_unsolved', 'Discarded by unsolved', '1', NOW(), NOW(), 'close')");
        $this->addSql("INSERT INTO incident_state (`slug`, `name`, `is_active`, `created_at`, `updated_at`, `incident_state_behavior`) VALUES ('discarded_by_unattended', 'Discarded by unattended', '1', NOW(), NOW(), 'close')");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_priority DROP unresponse_time, DROP unresolution_time');
    }
}
