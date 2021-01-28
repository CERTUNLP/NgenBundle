<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210128190655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A3AA33DF6');
        $this->addSql('DROP INDEX IDX_3D03A11A3AA33DF6 ON incident');
        $this->addSql('ALTER TABLE incident CHANGE unattended_state unresponded_state VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB7F06CD1 FOREIGN KEY (unresponded_state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11AB7F06CD1 ON incident (unresponded_state)');

        $this->addSql('ALTER TABLE incident_priority CHANGE resolution_time solve_time INT NOT NULL');
        $this->addSql('ALTER TABLE incident_priority CHANGE unresolution_time unsolve_time INT NOT NULL');

        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B7DC9D7A5');
        $this->addSql('DROP INDEX IDX_7C69DA3B3AA33DF6 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision CHANGE unattended_state unresponded_state VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BB7F06CD1 FOREIGN KEY (unresponded_state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BB7F06CD1 ON incident_decision (unresponded_state)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB7F06CD1');
        $this->addSql('DROP INDEX IDX_3D03A11AB7F06CD1 ON incident');
        $this->addSql('ALTER TABLE incident CHANGE unresponded_state unattended_state VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A3AA33DF6 FOREIGN KEY (unattended_state) REFERENCES incident_state (slug) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_3D03A11A3AA33DF6 ON incident (unattended_state)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BB7F06CD1');
        $this->addSql('DROP INDEX IDX_7C69DA3BB7F06CD1 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision CHANGE unresponded_state unattended_state VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B7DC9D7A5 FOREIGN KEY (unattended_state) REFERENCES incident_state (slug) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7C69DA3B3AA33DF6 ON incident_decision (unattended_state)');
        $this->addSql('ALTER TABLE incident_priority CHANGE solve_time resolution_time INT NOT NULL');
        $this->addSql('ALTER TABLE incident_priority CHANGE unsolve_time unresolution_time INT NOT NULL');        $this->addSql('ALTER TABLE incident_state_change DROP FOREIGN KEY FK_7A2C142459E53FB9');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
