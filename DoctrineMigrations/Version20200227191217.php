<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200227191217 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior CHANGE mode mode ENUM(\'manual\',\'file\',\'data\', \'all\')');
        $this->addSql('ALTER TABLE incident_decision CHANGE when_to_update when_to_update VARCHAR(100) NOT NULL');
//        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F1FB8D185');
//        $this->addSql('DROP INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread');
//        $this->addSql('ALTER TABLE incident_comment_thread DROP host_id');
        $this->addSql('ALTER TABLE incident_communication ADD CONSTRAINT FK_B89870BE59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_communication ADD CONSTRAINT FK_B89870BEEFE254FB FOREIGN KEY (ltd_id) REFERENCES incident_detected (id)');

        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME NOT NULL');


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior CHANGE mode mode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread ADD host_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread (host_id)');
        $this->addSql('ALTER TABLE incident_communication DROP FOREIGN KEY FK_B89870BE59E53FB9');
        $this->addSql('ALTER TABLE incident_communication DROP FOREIGN KEY FK_B89870BEEFE254FB');
        $this->addSql('ALTER TABLE incident_decision CHANGE when_to_update when_to_update VARCHAR(100) DEFAULT \'live\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected CHANGE when_to_update when_to_update VARCHAR(100) DEFAULT \'live\' COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}

