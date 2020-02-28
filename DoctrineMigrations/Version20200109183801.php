<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200109183801 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('ENUM', 'string');
        $this->addSql('CREATE TABLE decisions_communication_behavior (decision_id INT NOT NULL, behavior_slug VARCHAR(100) NOT NULL, INDEX IDX_4CC15E97BDEE7539 (decision_id), INDEX IDX_4CC15E97718BA7D1 (behavior_slug), PRIMARY KEY(decision_id, behavior_slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE decisions_communication_behavior ADD CONSTRAINT FK_4CC15E97BDEE7539 FOREIGN KEY (decision_id) REFERENCES incident_decision (id)');
        $this->addSql('ALTER TABLE decisions_communication_behavior ADD CONSTRAINT FK_4CC15E97718BA7D1 FOREIGN KEY (behavior_slug) REFERENCES communication_behavior (slug)');
        $this->addSql('ALTER TABLE communication_behavior CHANGE type type ENUM(\'new\',\'open\',\'update\', \'summary\'), CHANGE mode mode ENUM(\'manual\',\'file\',\'data\', \'all\')');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE decisions_commmunication_behavior');
        $this->addSql('ALTER TABLE communication_behavior CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE mode mode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP INDEX UNIQ_E073862F59E53FB9, ADD INDEX FK_E073862F59E53FB9_idx (incident_id)');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
    }
}
