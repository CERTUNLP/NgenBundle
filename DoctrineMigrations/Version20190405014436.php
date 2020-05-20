<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190405014436 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD opened_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_last_time_detected ADD feed VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_last_time_detected ADD CONSTRAINT FK_B0FEF4C7234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('CREATE INDEX IDX_B0FEF4C7234044AB ON incident_last_time_detected (feed)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP opened_at');
        $this->addSql('ALTER TABLE incident_last_time_detected DROP FOREIGN KEY FK_B0FEF4C7234044AB');
        $this->addSql('DROP INDEX IDX_B0FEF4C7234044AB ON incident_last_time_detected');
        $this->addSql('ALTER TABLE incident_last_time_detected DROP feed');
    }
}
