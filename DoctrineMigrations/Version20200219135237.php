<?php

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200219135237 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX fk_66d22096e371859c TO IDX_66D22096E371859C');
        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F1FB8D185');
        $this->addSql('DROP INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread');
        $this->addSql('ALTER TABLE incident_comment_thread DROP host_id');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DCB9A3939');
        $this->addSql('DROP INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state');
        $this->addSql('DROP INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state DROP newState, DROP oldState');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_change_state ADD newState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, ADD oldState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DCB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state (newState)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state (oldState)');
        $this->addSql('ALTER TABLE incident_comment_thread ADD host_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread (host_id)');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX idx_66d22096e371859c TO FK_66D22096E371859C');
        $this->addSql('ALTER TABLE taxonomy_predicate CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE taxonomy_value CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
    }
}
