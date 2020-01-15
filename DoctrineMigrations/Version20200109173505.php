<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200109173505 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior ADD type ENUM(\'new\',\'open\',\'update\', \'summary\'), ADD mode ENUM(\'manual\',\'file\',\'data\', \'all\'), DROP inNew, DROP inOpen, DROP inUpdate, DROP inSummary');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331B060C973');
        $this->addSql('DROP INDEX IDX_F9976331B060C973 ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected DROP communication_behavior');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096E371859C FOREIGN KEY (taxonomyValue) REFERENCES taxonomy_value (slug)');
        $this->addSql('CREATE INDEX IDX_66D22096E371859C ON incident_type (taxonomyValue)');
        $this->addSql("INSERT INTO `communication_behavior` (`slug`, `name`, `is_active`, `created_at`, `type`, `mode`) VALUES ('new_manual', 'new-manual', true, NOW(), 'new', 'manual')");
        $this->addSql(
            "INSERT INTO `communication_behavior` (`slug`, `name`, `is_active`, `created_at`, `type`, `mode`) VALUES ('open_manual', 'open-manual', true, NOW(), 'open', 'manual')"
        );
        $this->addSql(
            "INSERT INTO `communication_behavior` (`slug`, `name`, `is_active`, `created_at`, `type`, `mode`) VALUES ('update_manual', 'update-manual', true, NOW(), 'update', 'manual')"
        );
        $this->addSql(
            "INSERT INTO `communication_behavior` (`slug`, `name`, `is_active`, `created_at`, `type`, `mode`) VALUES ('summary_manual', 'summary-manual', true, NOW(), 'summary', 'manual')"
        );

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

         $this->addSql('ALTER TABLE communication_behavior ADD inNew VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD inOpen VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD inUpdate VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD inSummary VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP type, DROP mode');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected ADD communication_behavior VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331B060C973 FOREIGN KEY (communication_behavior) REFERENCES communication_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_F9976331B060C973 ON incident_detected (communication_behavior)');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096E371859C');
        $this->addSql('DROP INDEX IDX_66D22096E371859C ON incident_type');
    }
}
