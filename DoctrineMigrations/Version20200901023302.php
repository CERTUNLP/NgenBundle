<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200901023302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network CHANGE type type ENUM(\'internal\', \'external\',\'rdap\')');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_ccfc5a1d59e53fb9 TO IDX_7A2C142459E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_ccfc5a1d2f0d3b98 TO IDX_7A2C14242F0D3B98');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_ccfc5a1d53c59d72 TO IDX_7A2C142453C59D72');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_ccfc5a1db03a8386 TO IDX_7A2C1424B03A8386');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331E1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident_decision CHANGE auto_saved auto_saved TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment_thread ADD host_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread (host_id)');
        $this->addSql('ALTER TABLE incident_decision CHANGE auto_saved auto_saved TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E1CFE6F5');
        $this->addSql('ALTER TABLE incident_state_change ADD newState VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD oldState VARCHAR(100) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE incident_state_change ADD CONSTRAINT FK_CCFC5A1DCB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CCFC5A1D17EA0C41 ON incident_state_change (oldState)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DCB9A3939 ON incident_state_change (newState)');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c14242f0d3b98 TO IDX_CCFC5A1D2F0D3B98');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142453c59d72 TO IDX_CCFC5A1D53C59D72');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c142459e53fb9 TO IDX_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_state_change RENAME INDEX idx_7a2c1424b03a8386 TO IDX_CCFC5A1DB03A8386');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX idx_66d22096e371859c TO FK_66D22096E371859C');
        $this->addSql('ALTER TABLE network CHANGE type type VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
    }
}
