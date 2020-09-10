<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200823155355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE message CHANGE pending pending TINYINT(1) NOT NULL, CHANGE incident incident_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F59E53FB9 ON message (incident_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E1CFE6F5');
        $this->addSql('ALTER TABLE incident_state_change DROP FOREIGN KEY FK_7A2C142459E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c14242f0d3b98 TO IDX_CCFC5A1D2F0D3B98');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142453c59d72 TO IDX_CCFC5A1D53C59D72');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142459e53fb9 TO IDX_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c1424b03a8386 TO IDX_CCFC5A1DB03A8386');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F59E53FB9');
        $this->addSql('DROP INDEX IDX_B6BD307F59E53FB9 ON message');
        $this->addSql('ALTER TABLE message CHANGE incident_id incident_id INT NOT NULL, CHANGE pending pending TINYINT(1) DEFAULT NULL');
    }
}
