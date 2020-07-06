<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200706163511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact_case ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE network ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE network_admin ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE network_entity ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE host ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE state_edge ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE state_behavior ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_detected ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_type ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE taxonomy_predicate ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE taxonomy_value ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_priority ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_urgency ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_feed ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state_change ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_impact ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_decision ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_tlp ADD deletedAt DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_report ADD deletedAt DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact DROP deletedAt');
        $this->addSql('ALTER TABLE contact_case DROP deletedAt');
        $this->addSql('ALTER TABLE host DROP deletedAt');
        $this->addSql('ALTER TABLE incident DROP deletedAt');
        $this->addSql('ALTER TABLE incident_decision DROP deletedAt');
        $this->addSql('ALTER TABLE incident_detected DROP deletedAt');
        $this->addSql('ALTER TABLE incident_feed DROP deletedAt');
        $this->addSql('ALTER TABLE incident_impact DROP deletedAt');
        $this->addSql('ALTER TABLE incident_priority DROP deletedAt');
        $this->addSql('ALTER TABLE incident_report DROP deletedAt');
        $this->addSql('ALTER TABLE incident_state DROP deletedAt');
        $this->addSql('ALTER TABLE incident_state_change DROP deletedAt');
        $this->addSql('ALTER TABLE incident_tlp DROP deletedAt');
        $this->addSql('ALTER TABLE incident_type DROP deletedAt');
        $this->addSql('ALTER TABLE incident_urgency DROP deletedAt');
        $this->addSql('ALTER TABLE message DROP deletedAt');
        $this->addSql('ALTER TABLE network DROP deletedAt');
        $this->addSql('ALTER TABLE network_admin DROP deletedAt');
        $this->addSql('ALTER TABLE network_entity DROP deletedAt');
        $this->addSql('ALTER TABLE state_behavior  DROP deletedAt');
        $this->addSql('ALTER TABLE state_edge DROP deletedAt');
        $this->addSql('ALTER TABLE taxonomy_predicate DROP deletedAt');
        $this->addSql('ALTER TABLE taxonomy_value DROP deletedAt');
    }
}
