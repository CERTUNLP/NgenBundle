<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190830181310 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX ip ON host');
        $this->addSql('ALTER TABLE state_behavior DROP discard');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091B8037C6C');
        $this->addSql('DROP INDEX IDX_F8A770917DB76696 ON incident_state');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_decision RENAME INDEX idx_7c69da3b7dc9d7a5 TO IDX_7C69DA3B3AA33DF6');
        $this->addSql('ALTER TABLE incident DROP host_address, DROP is_discarded');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A3AA33DF6 FOREIGN KEY (unattended_state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AEC6344B7 FOREIGN KEY (unsolved_state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11A3AA33DF6 ON incident (unattended_state)');
        $this->addSql('CREATE INDEX IDX_3D03A11AEC6344B7 ON incident (unsolved_state)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE INDEX ip ON host (ip)');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AA393D2FB');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A3AA33DF6');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AEC6344B7');
        $this->addSql('DROP INDEX IDX_3D03A11A3AA33DF6 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AEC6344B7 ON incident');
        $this->addSql('ALTER TABLE incident ADD host_address VARCHAR(20) DEFAULT NULL COLLATE utf8_unicode_ci, ADD is_discarded TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_decision RENAME INDEX idx_7c69da3b3aa33df6 TO IDX_7C69DA3B7DC9D7A5');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331A393D2FB');
        $this->addSql('CREATE INDEX IDX_F8A770917DB76696 ON incident_state (behavior)');
        $this->addSql('ALTER TABLE state_behavior ADD discard TINYINT(1) NOT NULL');
    }
}
