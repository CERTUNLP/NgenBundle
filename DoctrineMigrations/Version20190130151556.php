<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190130151556 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {

        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP INDEX UNIQ_9A63B85477153098 ON incident_priority');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('DROP INDEX UNIQ_9A63B8545E237E06 ON incident_priority');
        $this->addSql('ALTER TABLE incident_priority CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A63B854989D9B62 ON incident_priority (slug)');
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('high_high', 'Critical', '0', '1', '1', 'high', 'high', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('high_medium', 'High', '10', '240', '2', 'high', 'medium', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('medium_high', 'High', '10', '240', '2', 'medium', 'high', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('low_high', 'Medium', '60', '480', '3', 'low', 'high', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('medium_medium', 'Medium', '60', '480', '3', 'medium', 'medium', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('high_low', 'Medium', '60', '480', '3', 'high', 'low', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('low_medium', 'Low', '240', '1440', '4', 'low', 'medium', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('medium_low', 'Low', '240', '1440', '4', 'medium', 'low', now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('low_low', 'Very Low', '1440', '10080', '5', 'low', 'low',  now(), now())");
        $this->addSql("INSERT INTO incident_priority (`slug`, `name`, `response_time`, `resolution_time`, `code`, `impact`, `urgency`, `created_at`, `updated_at`) VALUES ('undefined_undefined', 'Undefined', '0', '0', '0', 'undefined', 'undefined', now(), now())");
        $this->addSql('ALTER TABLE incident_priority CHANGE response_time response_time INT NOT NULL, CHANGE resolution_time resolution_time INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AC409C007');
        $this->addSql('DROP INDEX UNIQ_9A63B854989D9B62 ON incident_priority');
        $this->addSql('ALTER TABLE incident_priority CHANGE slug slug VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A63B8545E237E06 ON incident_priority (name)');
    }
}
