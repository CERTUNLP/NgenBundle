<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190902142125 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
        $this->addSql('UPDATE incident_state SET incident_state.behavior = "closed" where behavior = "close"');
        $this->addSql('UPDATE incident_state SET incident_state.behavior = "discarded" where behavior = "discard"');
        $this->addSql('UPDATE incident_state SET incident_state.behavior = "on_treatment" where behavior = "open"');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    }
}
