<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200807230826 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B677C3782');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BC409C007');
        $this->addSql('DROP INDEX IDX_7C69DA3B677C3782 ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BC409C007 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision ADD priority_id INT DEFAULT NULL');
        $this->addSql('update incident_decision id    INNER JOIN incident_priority ip ON id.urgency = ip.urgency and id.impact = ip.impact SET id.priority_id = ip.id');
        $this->addSql('ALTER TABLE incident_decision DROP impact, DROP urgency, DROP slug');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B497B19F9 FOREIGN KEY (priority_id) REFERENCES incident_priority (id)');
        $this->addSql('CREATE INDEX IDX_7C69DA3B497B19F9 ON incident_decision (priority_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B497B19F9');
        $this->addSql('DROP INDEX IDX_7C69DA3B497B19F9 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision ADD impact VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD urgency VARCHAR(45) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD slug VARCHAR(100) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, DROP priority_id');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B677C3782 FOREIGN KEY (urgency) REFERENCES incident_urgency (slug) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_7C69DA3B677C3782 ON incident_decision (urgency)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BC409C007 ON incident_decision (impact)');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E1CFE6F5');
        $this->addSql('ALTER TABLE incident_state_change DROP FOREIGN KEY FK_7A2C142459E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c14242f0d3b98 TO IDX_CCFC5A1D2F0D3B98');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142453c59d72 TO IDX_CCFC5A1D53C59D72');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142459e53fb9 TO IDX_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c1424b03a8386 TO IDX_CCFC5A1DB03A8386');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
