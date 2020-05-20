<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190405010356 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_last_time_detected (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, date_detected DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B0FEF4C759E53FB9 (incident_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_last_time_detected ADD CONSTRAINT FK_B0FEF4C759E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A234044AB');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A34128B91');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A56A273CC');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A62A6DC27');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A816C6140');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A8CDE5729');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AA393D2FB');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1501A05');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1CFE6F5');
        $this->addSql('ALTER TABLE incident ADD is_new TINYINT(1) NOT NULL, DROP last_time_detected');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A34128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A56A273CC FOREIGN KEY (origin_id) REFERENCES host (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A62A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A816C6140 FOREIGN KEY (destination_id) REFERENCES host (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A8CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1501A05 FOREIGN KEY (assigned_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident_comment DROP FOREIGN KEY FK_33BE48B1E2904019');
        $this->addSql('ALTER TABLE incident_comment ADD CONSTRAINT FK_33BE48B1E2904019 FOREIGN KEY (thread_id) REFERENCES incident_comment_thread (id)');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_decision_google (id INT DEFAULT NULL, type TEXT DEFAULT NULL COLLATE latin1_swedish_ci, feed TEXT DEFAULT NULL COLLATE latin1_swedish_ci, impact TEXT DEFAULT NULL COLLATE latin1_swedish_ci, urgency TEXT DEFAULT NULL COLLATE latin1_swedish_ci, tlp TEXT DEFAULT NULL COLLATE latin1_swedish_ci, state TEXT DEFAULT NULL COLLATE latin1_swedish_ci, network TEXT DEFAULT NULL COLLATE latin1_swedish_ci, created_at TEXT DEFAULT NULL COLLATE latin1_swedish_ci, updated_at TEXT DEFAULT NULL COLLATE latin1_swedish_ci, auto_saved INT DEFAULT NULL, is_active INT DEFAULT NULL, slug TEXT DEFAULT NULL COLLATE latin1_swedish_ci) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE incident_last_time_detected');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1CFE6F5');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1501A05');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A8CDE5729');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A234044AB');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AA393D2FB');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A62A6DC27');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A56A273CC');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A816C6140');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A34128B91');
        $this->addSql('ALTER TABLE incident ADD last_time_detected DATETIME DEFAULT NULL, DROP is_new');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1501A05 FOREIGN KEY (assigned_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A8CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES incident_tlp (slug) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A62A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A56A273CC FOREIGN KEY (origin_id) REFERENCES host (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A816C6140 FOREIGN KEY (destination_id) REFERENCES host (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A34128B91 FOREIGN KEY (network_id) REFERENCES network (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident_comment DROP FOREIGN KEY FK_33BE48B1E2904019');
        $this->addSql('ALTER TABLE incident_comment ADD CONSTRAINT FK_33BE48B1E2904019 FOREIGN KEY (thread_id) REFERENCES incident_comment_thread (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
