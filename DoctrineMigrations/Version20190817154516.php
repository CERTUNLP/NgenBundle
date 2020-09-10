<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190817154516 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770911F1854A9');
        $this->addSql('ALTER TABLE incident_state CHANGE incident_state_behavior behavior VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770913BABA0B0 FOREIGN KEY (behavior) REFERENCES incident_state_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_F8A770913BABA0B0 ON incident_state (behavior)');
        $this->addSql('ALTER TABLE incident DROP opened_at');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD opened_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
        $this->addSql('DROP INDEX IDX_F8A770913BABA0B0 ON incident_state');
        $this->addSql('ALTER TABLE incident_state CHANGE behavior incident_state_behavior VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770911F1854A9 FOREIGN KEY (incident_state_behavior) REFERENCES incident_state_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_F8A770911F1854A9 ON incident_state (incident_state_behavior)');
    }
}
