<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160511172025 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES internal_incident (id)');
        $this->addSql('ALTER TABLE external_incident CHANGE network_entity network_entity VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2234044AB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC234128B91');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC27D33BAAB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC28CDE5729');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2A393D2FB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2C9E8B981');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2E1CFE6F5');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11A234044AB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11A34128B91');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11A7D33BAAB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11A8CDE5729');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11AA393D2FB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11AC9E8B981');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_3D03A11AE1CFE6F5');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2234044AB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC234128B91');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC27D33BAAB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC28CDE5729');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2A393D2FB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2C9E8B981');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2E1CFE6F5');
        $this->addSql('DROP INDEX uniq_3d03a11a989d9b62 ON internal_incident');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F2A12CC2989D9B62 ON internal_incident (slug)');
        $this->addSql('DROP INDEX idx_3d03a11ac9e8b981 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC2C9E8B981 ON internal_incident (network_admin_id)');
        $this->addSql('DROP INDEX idx_3d03a11a7d33baab ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC27D33BAAB ON internal_incident (academic_unit_id)');
        $this->addSql('DROP INDEX idx_3d03a11a8cde5729 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC28CDE5729 ON internal_incident (type)');
        $this->addSql('DROP INDEX idx_3d03a11a234044ab ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC2234044AB ON internal_incident (feed)');
        $this->addSql('DROP INDEX idx_3d03a11aa393d2fb ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC2A393D2FB ON internal_incident (state)');
        $this->addSql('DROP INDEX idx_3d03a11a34128b91 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC234128B91 ON internal_incident (network_id)');
        $this->addSql('DROP INDEX idx_3d03a11ae1cfe6f5 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_F2A12CC2E1CFE6F5 ON internal_incident (reporter_id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11A234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11A34128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11A7D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11A8CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11AC9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_3D03A11AE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC234128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC27D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC28CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2C9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE external_incident CHANGE network_entity network_entity VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2C9E8B981');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC27D33BAAB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC28CDE5729');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2234044AB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2A393D2FB');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC234128B91');
        $this->addSql('ALTER TABLE internal_incident DROP FOREIGN KEY FK_F2A12CC2E1CFE6F5');
        $this->addSql('DROP INDEX uniq_f2a12cc2989d9b62 ON internal_incident');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D03A11A989D9B62 ON internal_incident (slug)');
        $this->addSql('DROP INDEX idx_f2a12cc2c9e8b981 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11AC9E8B981 ON internal_incident (network_admin_id)');
        $this->addSql('DROP INDEX idx_f2a12cc27d33baab ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A7D33BAAB ON internal_incident (academic_unit_id)');
        $this->addSql('DROP INDEX idx_f2a12cc28cde5729 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A8CDE5729 ON internal_incident (type)');
        $this->addSql('DROP INDEX idx_f2a12cc2234044ab ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A234044AB ON internal_incident (feed)');
        $this->addSql('DROP INDEX idx_f2a12cc2a393d2fb ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11AA393D2FB ON internal_incident (state)');
        $this->addSql('DROP INDEX idx_f2a12cc234128b91 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11A34128B91 ON internal_incident (network_id)');
        $this->addSql('DROP INDEX idx_f2a12cc2e1cfe6f5 ON internal_incident');
        $this->addSql('CREATE INDEX IDX_3D03A11AE1CFE6F5 ON internal_incident (reporter_id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2C9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC27D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC28CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC234128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE internal_incident ADD CONSTRAINT FK_F2A12CC2E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
    }
}
