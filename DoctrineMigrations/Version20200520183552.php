<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200520183552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD created_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4C62E638B03A8386 ON contact (created_by_id)');
        $this->addSql('ALTER TABLE contact_case ADD created_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_case ADD CONSTRAINT FK_50F71BFBB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_50F71BFBB03A8386 ON contact_case (created_by_id)');
        $this->addSql('ALTER TABLE message ADD created_by_id INT DEFAULT NULL, CHANGE data data JSON NOT NULL, CHANGE response response JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FB03A8386 ON message (created_by_id)');
        $this->addSql('ALTER TABLE network ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BCB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_608487BCB03A8386 ON network (created_by_id)');
        $this->addSql('ALTER TABLE network_admin ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE network_admin ADD CONSTRAINT FK_4614B42AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4614B42AB03A8386 ON network_admin (created_by_id)');

        $this->addSql('ALTER TABLE network_entity ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE network_entity ADD CONSTRAINT FK_6C3B430EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6C3B430EB03A8386 ON network_entity (created_by_id)');

        $this->addSql('ALTER TABLE host ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE host ADD CONSTRAINT FK_CF2713FDB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CF2713FDB03A8386 ON host (created_by_id)');

        $this->addSql('ALTER TABLE state_edge ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E1E55AA0B03A8386 ON state_edge (created_by_id)');

        $this->addSql('ALTER TABLE state_behavior ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE state_behavior ADD CONSTRAINT FK_458C617B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_458C617B03A8386 ON state_behavior (created_by_id)');

        $this->addSql('ALTER TABLE incident_state ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F8A77091B03A8386 ON incident_state (created_by_id)');

        $this->addSql('ALTER TABLE incident_detected ADD created_by_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
//        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F997633159E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('CREATE INDEX IDX_F9976331B03A8386 ON incident_detected (created_by_id)');

        $this->addSql('ALTER TABLE incident_type ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL,  CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_66D22096B03A8386 ON incident_type (created_by_id)');

        $this->addSql('ALTER TABLE taxonomy_predicate ADD created_by_id INT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_predicate ADD CONSTRAINT FK_28010D24B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_28010D24B03A8386 ON taxonomy_predicate (created_by_id)');

        $this->addSql('ALTER TABLE taxonomy_value ADD created_by_id INT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value ADD CONSTRAINT FK_48109C99B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_48109C99B03A8386 ON taxonomy_value (created_by_id)');

        $this->addSql('ALTER TABLE incident_priority ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_priority ADD CONSTRAINT FK_9A63B854B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_9A63B854B03A8386 ON incident_priority (created_by_id)');

//        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');

        $this->addSql('ALTER TABLE incident_urgency ADD created_by_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_urgency ADD CONSTRAINT FK_C0B62D5FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C0B62D5FB03A8386 ON incident_urgency (created_by_id)');

        $this->addSql('ALTER TABLE incident_feed ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_feed ADD CONSTRAINT FK_C94C3314B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C94C3314B03A8386 ON incident_feed (created_by_id)');

        $this->addSql('ALTER TABLE incident_impact ADD created_by_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_impact ADD CONSTRAINT FK_69357CE3B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_69357CE3B03A8386 ON incident_impact (created_by_id)');

        $this->addSql('ALTER TABLE incident_change_state ADD created_by_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
//        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DB03A8386 ON incident_change_state (created_by_id)');

        $this->addSql('ALTER TABLE incident_decision ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BB03A8386 ON incident_decision (created_by_id)');

        $this->addSql('ALTER TABLE incident ADD created_by_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11AB03A8386 ON incident (created_by_id)');

        $this->addSql('ALTER TABLE incident_tlp ADD created_by_id INT DEFAULT NULL, ADD active TINYINT(1) NOT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_tlp ADD CONSTRAINT FK_ECC4CA8DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ECC4CA8DB03A8386 ON incident_tlp (created_by_id)');
        $this->addSql('DROP INDEX UNIQ_6913CB60989D9B62 ON incident_report');

        $this->addSql('ALTER TABLE incident_report ADD created_by_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL, CHANGE is_active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_report ADD CONSTRAINT FK_6913CB60B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6913CB60B03A8386 ON incident_report (created_by_id)');

        $this->addSql('ALTER TABLE user ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B03A8386 ON user (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638B03A8386');
        $this->addSql('DROP INDEX IDX_4C62E638B03A8386 ON contact');
        $this->addSql('ALTER TABLE contact DROP created_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE contact_case DROP FOREIGN KEY FK_50F71BFBB03A8386');
        $this->addSql('DROP INDEX IDX_50F71BFBB03A8386 ON contact_case');
        $this->addSql('ALTER TABLE contact_case DROP created_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE host DROP FOREIGN KEY FK_CF2713FDB03A8386');
        $this->addSql('DROP INDEX IDX_CF2713FDB03A8386 ON host');
        $this->addSql('ALTER TABLE host DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB03A8386');
        $this->addSql('DROP INDEX IDX_3D03A11AB03A8386 ON incident');
        $this->addSql('ALTER TABLE incident DROP created_by_id, DROP active, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DB03A8386');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('DROP INDEX IDX_CCFC5A1DB03A8386 ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state DROP created_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BB03A8386');
        $this->addSql('DROP INDEX IDX_7C69DA3BB03A8386 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331B03A8386');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('DROP INDEX IDX_F9976331B03A8386 ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected DROP created_by_id, DROP active, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE incident_feed DROP FOREIGN KEY FK_C94C3314B03A8386');
        $this->addSql('DROP INDEX IDX_C94C3314B03A8386 ON incident_feed');
        $this->addSql('ALTER TABLE incident_feed DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_impact DROP FOREIGN KEY FK_69357CE3B03A8386');
        $this->addSql('DROP INDEX IDX_69357CE3B03A8386 ON incident_impact');
        $this->addSql('ALTER TABLE incident_impact DROP created_by_id, DROP active, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE incident_priority DROP FOREIGN KEY FK_9A63B854B03A8386');
        $this->addSql('DROP INDEX IDX_9A63B854B03A8386 ON incident_priority');
        $this->addSql('ALTER TABLE incident_priority DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_report DROP FOREIGN KEY FK_6913CB60B03A8386');
        $this->addSql('DROP INDEX IDX_6913CB60B03A8386 ON incident_report');
        $this->addSql('ALTER TABLE incident_report DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6913CB60989D9B62 ON incident_report (slug)');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091B03A8386');
        $this->addSql('DROP INDEX IDX_F8A77091B03A8386 ON incident_state');
        $this->addSql('ALTER TABLE incident_state DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_tlp DROP FOREIGN KEY FK_ECC4CA8DB03A8386');
        $this->addSql('DROP INDEX IDX_ECC4CA8DB03A8386 ON incident_tlp');
        $this->addSql('ALTER TABLE incident_tlp DROP created_by_id, DROP active, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096B03A8386');
        $this->addSql('DROP INDEX IDX_66D22096B03A8386 ON incident_type');
        $this->addSql('ALTER TABLE incident_type DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_urgency DROP FOREIGN KEY FK_C0B62D5FB03A8386');
        $this->addSql('DROP INDEX IDX_C0B62D5FB03A8386 ON incident_urgency');
        $this->addSql('ALTER TABLE incident_urgency DROP created_by_id, DROP active, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FB03A8386');
        $this->addSql('DROP INDEX IDX_B6BD307FB03A8386 ON message');
        $this->addSql('ALTER TABLE message DROP created_by_id, CHANGE data data JSON NOT NULL COMMENT \'(DC2Type:json_array)\', CHANGE response response JSON DEFAULT NULL COMMENT \'(DC2Type:json_array)\'');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BCB03A8386');
        $this->addSql('DROP INDEX IDX_608487BCB03A8386 ON network');
        $this->addSql('ALTER TABLE network DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE network_admin DROP FOREIGN KEY FK_4614B42AB03A8386');
        $this->addSql('DROP INDEX IDX_4614B42AB03A8386 ON network_admin');
        $this->addSql('ALTER TABLE network_admin DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE network_entity DROP FOREIGN KEY FK_6C3B430EB03A8386');
        $this->addSql('DROP INDEX IDX_6C3B430EB03A8386 ON network_entity');
        $this->addSql('ALTER TABLE network_entity DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE state_behavior DROP FOREIGN KEY FK_458C617B03A8386');
        $this->addSql('DROP INDEX IDX_458C617B03A8386 ON state_behavior');
        $this->addSql('ALTER TABLE state_behavior DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE state_edge DROP FOREIGN KEY FK_E1E55AA0B03A8386');
        $this->addSql('DROP INDEX IDX_E1E55AA0B03A8386 ON state_edge');
        $this->addSql('ALTER TABLE state_edge ADD is_active TINYINT(1) NOT NULL, DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_predicate DROP FOREIGN KEY FK_28010D24B03A8386');
        $this->addSql('DROP INDEX IDX_28010D24B03A8386 ON taxonomy_predicate');
        $this->addSql('ALTER TABLE taxonomy_predicate DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value DROP FOREIGN KEY FK_48109C99B03A8386');
        $this->addSql('DROP INDEX IDX_48109C99B03A8386 ON taxonomy_value');
        $this->addSql('ALTER TABLE taxonomy_value DROP created_by_id, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B03A8386');
        $this->addSql('DROP INDEX IDX_8D93D649B03A8386 ON user');
        $this->addSql('ALTER TABLE user DROP created_by_id');
    }
}
