<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190410183044 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_detected (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, assigned_id INT DEFAULT NULL, type VARCHAR(100) DEFAULT NULL, feed VARCHAR(100) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, tlp_state VARCHAR(45) DEFAULT NULL, priority VARCHAR(255) DEFAULT NULL, date DATETIME DEFAULT NULL, evidence_file_path VARCHAR(255) DEFAULT NULL, INDEX IDX_F997633159E53FB9 (incident_id), INDEX IDX_F9976331E1501A05 (assigned_id), INDEX IDX_F99763318CDE5729 (type), INDEX IDX_F9976331234044AB (feed), INDEX IDX_F9976331A393D2FB (state), INDEX IDX_F9976331B8037C6C (tlp_state), INDEX IDX_F997633162A6DC27 (priority), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F997633159E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331E1501A05 FOREIGN KEY (assigned_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F99763318CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331B8037C6C FOREIGN KEY (tlp_state) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F997633162A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug)');
        $this->addSql('DROP TABLE incident_last_time_detected');
        $this->addSql('ALTER TABLE incident_tlp ADD code INT DEFAULT NULL');
        $this->addSql("UPDATE `incident_tlp` SET `code`='2' WHERE `slug`='amber'");
        $this->addSql("UPDATE `incident_tlp` SET `code` = '0' WHERE `slug` = 'white'");
        $this->addSql("UPDATE `incident_tlp` SET `code` = '3' WHERE `slug` = 'red'");
        $this->addSql("UPDATE `incident_tlp` SET `code` = '1' WHERE `slug` = 'green'");
        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_last_time_detected (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, feed VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, date_detected DATETIME DEFAULT NULL, INDEX IDX_B0FEF4C759E53FB9 (incident_id), INDEX IDX_B0FEF4C7234044AB (feed), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE incident_last_time_detected ADD CONSTRAINT FK_B0FEF4C7234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE incident_last_time_detected ADD CONSTRAINT FK_B0FEF4C759E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('DROP TABLE incident_detected');
        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE incident_tlp DROP code');
    }
}
