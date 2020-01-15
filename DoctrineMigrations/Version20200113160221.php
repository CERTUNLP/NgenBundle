<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200113160221 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE decisions_communication_behavior');
        $this->addSql('ALTER TABLE communication_behavior CHANGE type type ENUM(\'new\',\'open\',\'update\', \'summary\'), CHANGE mode mode ENUM(\'manual\',\'file\',\'data\', \'all\')');
        $this->addSql('ALTER TABLE incident_decision ADD communication_behavior_new VARCHAR(100) DEFAULT NULL, ADD communication_behavior_update VARCHAR(100) DEFAULT NULL, ADD communication_behavior_open VARCHAR(100) DEFAULT NULL, ADD communication_behavior_summary VARCHAR(100) DEFAULT NULL, ADD communication_behavior_close VARCHAR(100) DEFAULT NULL, ADD when_to_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B6FE02729 FOREIGN KEY (communication_behavior_new) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BE316EE6 FOREIGN KEY (communication_behavior_update) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BE070ADB4 FOREIGN KEY (communication_behavior_open) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BD909CC7B FOREIGN KEY (communication_behavior_summary) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BEF2918E FOREIGN KEY (communication_behavior_close) REFERENCES communication_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_7C69DA3B6FE02729 ON incident_decision (communication_behavior_new)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BE316EE6 ON incident_decision (communication_behavior_update)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BE070ADB4 ON incident_decision (communication_behavior_open)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BD909CC7B ON incident_decision (communication_behavior_summary)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BEF2918E ON incident_decision (communication_behavior_close)');

            $this->addSql('ALTER TABLE incident_detected ADD communication_behavior_update VARCHAR(100) DEFAULT NULL, ADD communication_behavior_open VARCHAR(100) DEFAULT NULL, ADD communication_behavior_summary VARCHAR(100) DEFAULT NULL, ADD communication_behavior_close VARCHAR(100) DEFAULT NULL, ADD intelmq_data JSON NOT NULL COMMENT \'(DC2Type:json_array)\'');

        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331E316EE6 FOREIGN KEY (communication_behavior_update) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331E070ADB4 FOREIGN KEY (communication_behavior_open) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331D909CC7B FOREIGN KEY (communication_behavior_summary) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331EF2918E FOREIGN KEY (communication_behavior_close) REFERENCES communication_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_F9976331E316EE6 ON incident_detected (communication_behavior_update)');
        $this->addSql('CREATE INDEX IDX_F9976331E070ADB4 ON incident_detected (communication_behavior_open)');
        $this->addSql('CREATE INDEX IDX_F9976331D909CC7B ON incident_detected (communication_behavior_summary)');
        $this->addSql('CREATE INDEX IDX_F9976331EF2918E ON incident_detected (communication_behavior_close)');
        #Este fix es para acomodar todos los que esten mal configurados
            $this->addSql('update incident set unsolved_state="closed_by_inactivity" where unsolved_state is NULL');
            $this->addSql('update incident set unattended_state="discarded_by_innactivity" where unattended_state is NULL');
            $this->addSql('update incident set solve_dead_line=ADDDATE(incident.date, INTERVAL 45 DAY) where solve_dead_line is NULL');
            $this->addSql('update incident set response_dead_line=ADDDATE(incident.date, INTERVAL 15 DAY) where response_dead_line is NULL');
            $this->addSql('update incident_decision set unsolved_state="closed_by_inactivity" where unsolved_state is NULL');
            $this->addSql('update incident_decision set unattended_state="discarded_by_innactivity" where unattended_state is NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*$this->addSql('CREATE TABLE decisions_communication_behavior (decision_id INT NOT NULL, behavior_slug VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_4CC15E97BDEE7539 (decision_id), INDEX IDX_4CC15E97718BA7D1 (behavior_slug), PRIMARY KEY(decision_id, behavior_slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE decisions_communication_behavior ADD CONSTRAINT FK_4CC15E97718BA7D1 FOREIGN KEY (behavior_slug) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE decisions_communication_behavior ADD CONSTRAINT FK_4CC15E97BDEE7539 FOREIGN KEY (decision_id) REFERENCES incident_decision (id)');
        $this->addSql('ALTER TABLE communication_behavior CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE mode mode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        */
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B6FE02729');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BE316EE6');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BE070ADB4');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BD909CC7B');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BEF2918E');
        $this->addSql('DROP INDEX IDX_7C69DA3B6FE02729 ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BE316EE6 ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BE070ADB4 ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BD909CC7B ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BEF2918E ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision DROP communication_behavior_new, DROP communication_behavior_update, DROP communication_behavior_open, DROP communication_behavior_summary, DROP communication_behavior_close, DROP when_to_update');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E316EE6');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E070ADB4');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331D909CC7B');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331EF2918E');
        $this->addSql('DROP INDEX IDX_F9976331E316EE6 ON incident_detected');
        $this->addSql('DROP INDEX IDX_F9976331E070ADB4 ON incident_detected');
        $this->addSql('DROP INDEX IDX_F9976331D909CC7B ON incident_detected');
        $this->addSql('DROP INDEX IDX_F9976331EF2918E ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected DROP communication_behavior_update, DROP communication_behavior_open, DROP communication_behavior_summary, DROP communication_behavior_close, DROP intelmq_data');
    }
}
