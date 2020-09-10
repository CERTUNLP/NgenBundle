<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190612161900 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_state_edge (id INT AUTO_INCREMENT NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, oldState VARCHAR(100) DEFAULT NULL, newState VARCHAR(100) DEFAULT NULL, INDEX IDX_AF282D1117EA0C41 (oldState), INDEX IDX_AF282D11CB9A3939 (newState), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D1117EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_action ADD can_open TINYINT(1) NOT NULL, ADD can_close TINYINT(1) NOT NULL, ADD can_re_open TINYINT(1) NOT NULL, ADD is_active TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL DEFAULT NOW(), ADD updated_at DATETIME NOT NULL DEFAULT NOW(), ADD can_edit TINYINT(1) NOT NULL, ADD can_enrich TINYINT(1) NOT NULL, ADD can_add_history TINYINT(1) NOT NULL, ADD can_comunicate TINYINT(1) NOT NULL, DROP open, DROP close, DROP re_open');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770917DB76696');
        $this->addSql('ALTER TABLE incident_state  CHANGE incident_state_action incident_state_behavior VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770911F1854A9 FOREIGN KEY (incident_state_behavior) REFERENCES incident_state_action (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770914D6109E2');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091611041E3');
        $this->addSql('CREATE TABLE ext_translations2 (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL COLLATE utf8_unicode_ci, object_class VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, field VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, foreign_key VARCHAR(64) NOT NULL COLLATE utf8_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE incident_state_edge');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770911F1854A9');
        $this->addSql('DROP INDEX IDX_F8A770911F1854A9 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A770914D6109E2 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091611041E3 ON incident_state');
        $this->addSql('ALTER TABLE incident_state DROP old_edges_id, DROP new_edges_id, CHANGE incident_state_behavior incident_state_action VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770917DB76696 FOREIGN KEY (incident_state_action) REFERENCES incident_state_action (slug)');
        $this->addSql('CREATE INDEX IDX_F8A770917DB76696 ON incident_state (incident_state_action)');
        $this->addSql('ALTER TABLE incident_state_action ADD open TINYINT(1) NOT NULL, ADD close TINYINT(1) NOT NULL, ADD re_open TINYINT(1) NOT NULL, DROP can_open, DROP can_close, DROP can_re_open, DROP is_active, DROP created_at, DROP updated_at, DROP can_edit, DROP can_enrich, DROP can_add_history, DROP can_comunicate');
    }
}
