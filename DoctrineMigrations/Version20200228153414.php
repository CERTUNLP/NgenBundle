<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200228153414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior CHANGE mode mode ENUM(\'manual\',\'file\',\'data\', \'all\')');

        $this->addSql('ALTER TABLE incident ADD communication_behavior_update VARCHAR(100) DEFAULT NULL, ADD communication_behavior_open VARCHAR(100) DEFAULT NULL, ADD communication_behavior_summary VARCHAR(100) DEFAULT NULL, ADD communication_behavior_close VARCHAR(100) DEFAULT NULL, ADD when_to_update VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE316EE6 FOREIGN KEY (communication_behavior_update) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE070ADB4 FOREIGN KEY (communication_behavior_open) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AD909CC7B FOREIGN KEY (communication_behavior_summary) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AEF2918E FOREIGN KEY (communication_behavior_close) REFERENCES communication_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11AE316EE6 ON incident (communication_behavior_update)');
        $this->addSql('CREATE INDEX IDX_3D03A11AE070ADB4 ON incident (communication_behavior_open)');
        $this->addSql('CREATE INDEX IDX_3D03A11AD909CC7B ON incident (communication_behavior_summary)');
        $this->addSql('CREATE INDEX IDX_3D03A11AEF2918E ON incident (communication_behavior_close)');
        $this->addSql('ALTER TABLE incident_detected CHANGE when_to_update when_to_update VARCHAR(100)');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior CHANGE mode mode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE316EE6');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE070ADB4');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AD909CC7B');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AEF2918E');
        $this->addSql('DROP INDEX IDX_3D03A11AE316EE6 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AE070ADB4 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AD909CC7B ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AEF2918E ON incident');
        $this->addSql('ALTER TABLE incident DROP communication_behavior_update, DROP communication_behavior_open, DROP communication_behavior_summary, DROP communication_behavior_close, DROP when_to_update');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected CHANGE when_to_update when_to_update VARCHAR(100) DEFAULT \'live\' COLLATE utf8_unicode_ci');
    }
}
