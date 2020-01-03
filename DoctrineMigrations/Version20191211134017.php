<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191211134017 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F997633159E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX fk_66d22096e371859c TO IDX_66D22096E371859C');
        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX idx_66d22096e371859c TO FK_66D22096E371859C');
        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
