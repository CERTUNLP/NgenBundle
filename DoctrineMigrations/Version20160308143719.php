<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160308143719 extends AbstractMigration {

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('RENAME TABLE incident TO internal_incident');

        $this->addSql('CREATE TABLE external_incident (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, feed VARCHAR(100) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, reporter_id INT DEFAULT NULL, host_address VARCHAR(20) NOT NULL, date DATE NOT NULL, last_time_detected DATETIME DEFAULT NULL, renotification_date DATETIME DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_closed TINYINT(1) NOT NULL, evidence_file_path VARCHAR(255) DEFAULT NULL, report_message_id VARCHAR(255) DEFAULT NULL, network VARCHAR(255) NOT NULL, network_admin VARCHAR(255) NOT NULL, network_entity VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D20F13E9989D9B62 (slug), INDEX IDX_D20F13E98CDE5729 (type), INDEX IDX_D20F13E9234044AB (feed), INDEX IDX_D20F13E9A393D2FB (state), INDEX IDX_D20F13E9E1CFE6F5 (reporter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
//        $this->addSql('CREATE TABLE internal_incident (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, feed VARCHAR(100) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, reporter_id INT DEFAULT NULL, network_admin_id INT DEFAULT NULL, academic_unit_id INT DEFAULT NULL, network_id INT DEFAULT NULL, host_address VARCHAR(20) NOT NULL, date DATE NOT NULL, last_time_detected DATETIME DEFAULT NULL, renotification_date DATETIME DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_closed TINYINT(1) NOT NULL, evidence_file_path VARCHAR(255) DEFAULT NULL, report_message_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_F2A12CC2989D9B62 (slug), INDEX IDX_F2A12CC28CDE5729 (type), INDEX IDX_F2A12CC2234044AB (feed), INDEX IDX_F2A12CC2A393D2FB (state), INDEX IDX_F2A12CC2E1CFE6F5 (reporter_id), INDEX IDX_F2A12CC2C9E8B981 (network_admin_id), INDEX IDX_F2A12CC27D33BAAB (academic_unit_id), INDEX IDX_F2A12CC234128B91 (network_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE external_incident ADD CONSTRAINT FK_D20F13E98CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE external_incident ADD CONSTRAINT FK_D20F13E9234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE external_incident ADD CONSTRAINT FK_D20F13E9A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE external_incident ADD CONSTRAINT FK_D20F13E9E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC28CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2C9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC27D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC234128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, feed VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, network_id INT DEFAULT NULL, academic_unit_id INT DEFAULT NULL, type VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, state VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, network_admin_id INT DEFAULT NULL, reporter_id INT DEFAULT NULL, host_address VARCHAR(20) NOT NULL COLLATE utf8_unicode_ci, date DATE NOT NULL, last_time_detected DATETIME DEFAULT NULL, renotification_date DATETIME DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_closed TINYINT(1) NOT NULL, evidence_file_path VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, report_message_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_3D03A11A989D9B62 (slug), INDEX IDX_3D03A11AC9E8B981 (network_admin_id), INDEX IDX_3D03A11A7D33BAAB (academic_unit_id), INDEX IDX_3D03A11A8CDE5729 (type), INDEX IDX_3D03A11A234044AB (feed), INDEX IDX_3D03A11AA393D2FB (state), INDEX IDX_3D03A11A34128B91 (network_id), INDEX IDX_3D03A11AE1CFE6F5 (reporter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A34128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A7D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A8CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE external_incident');
        $this->addSql('DROP TABLE internal_incident');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
    }

}
