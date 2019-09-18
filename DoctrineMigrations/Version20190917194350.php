<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190917194350 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770913BABA0B0 FOREIGN KEY (behavior) REFERENCES state_behavior (slug)');
        $this->addSql("UPDATE `state_edge` SET `oldState`='initial' WHERE oldState not in (select slug from incident_state)");
        $this->addSql("UPDATE `state_edge` SET `newState`='discarded_by_unattended' WHERE newState not in (select slug from incident_state)");
        $this->addSql("ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA017EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)");
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
    }
}
