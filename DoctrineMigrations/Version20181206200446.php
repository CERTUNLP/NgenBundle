<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181206200446 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
        $this->addSql('ALTER TABLE network RENAME INDEX idx_608487bc7d33baab TO IDX_608487BC6801DB4');
        $this->addSql('ALTER TABLE incident_priority ADD impact VARCHAR(45) DEFAULT NULL, ADD urgency VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_priority ADD CONSTRAINT FK_9A63B854C409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('ALTER TABLE incident_priority ADD CONSTRAINT FK_9A63B854677C3782 FOREIGN KEY (urgency) REFERENCES incident_urgency (slug)');
        $this->addSql('CREATE INDEX IDX_9A63B854C409C007 ON incident_priority (impact)');
        $this->addSql('CREATE INDEX IDX_9A63B854677C3782 ON incident_priority (urgency)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_priority DROP FOREIGN KEY FK_9A63B854C409C007');
        $this->addSql('ALTER TABLE incident_priority DROP FOREIGN KEY FK_9A63B854677C3782');
        $this->addSql('DROP INDEX IDX_9A63B854C409C007 ON incident_priority');
        $this->addSql('DROP INDEX IDX_9A63B854677C3782 ON incident_priority');
        $this->addSql('ALTER TABLE incident_priority DROP impact, DROP urgency');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE network RENAME INDEX idx_608487bc6801db4 TO IDX_608487BC7D33BAAB');
    }
}
