<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190917154226 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('UPDATE state_behavior SET slug="closed" WHERE slug="close"');
        $this->addSql('UPDATE state_behavior SET slug="discarded" WHERE slug="discard"');
        $this->addSql('UPDATE state_behavior SET slug="on_treatment", name="On Treatment" WHERE slug="open"');
        $this->addSql('DELETE FROM incident_change_state where state_edge_id is null');
        $this->addSql("UPDATE incident_tlp SET name='amber' WHERE slug='amber'");
        $this->addSql("UPDATE incident_tlp SET name='green' WHERE slug='green';");
        $this->addSql("UPDATE incident_tlp SET name='red' WHERE slug='red';");
        $this->addSql("UPDATE incident_tlp SET name='white' WHERE slug='white';");
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
