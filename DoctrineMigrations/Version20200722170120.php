<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200722170120 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_change_state RENAME TO incident_state_change ;');
        $this->addSql('ALTER TABLE incident_state_change ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_F9976331E1CFE6F5 ON incident_detected (reporter_id)');
        $this->addSql('ALTER TABLE state_edge DROP active');
        $this->addSql('ALTER TABLE state_behavior DROP active');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_change_state (id INT AUTO_INCREMENT NOT NULL, responsable_id INT DEFAULT NULL, state_edge_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, incident_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, method VARCHAR(25) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_CCFC5A1D2F0D3B98 (state_edge_id), INDEX IDX_CCFC5A1D53C59D72 (responsable_id), INDEX IDX_CCFC5A1D59E53FB9 (incident_id), INDEX IDX_CCFC5A1DB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D2F0D3B98 FOREIGN KEY (state_edge_id) REFERENCES state_edge (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D53C59D72 FOREIGN KEY (responsable_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE incident_state_change');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331E1CFE6F5');
        $this->addSql('DROP INDEX IDX_F9976331E1CFE6F5 ON incident_detected');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE state_behavior ADD active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE state_edge ADD active TINYINT(1) NOT NULL');
    }
}
