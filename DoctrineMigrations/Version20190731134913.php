<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190731134913 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331A393D2FB');
        $this->addSql('DROP INDEX IDX_F9976331A393D2FB ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected ADD state_edge_id INT DEFAULT NULL, DROP state');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F99763312F0D3B98 FOREIGN KEY (state_edge_id) REFERENCES state_edge (id)');
        $this->addSql('CREATE INDEX IDX_F99763312F0D3B98 ON incident_detected (state_edge_id)');
        $this->addSql('ALTER TABLE incident DROP is_discarded');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD is_discarded TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F99763312F0D3B98');
        $this->addSql('DROP INDEX IDX_F99763312F0D3B98 ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected ADD state VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, DROP state_edge_id');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331A393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_F9976331A393D2FB ON incident_detected (state)');
    }
}
