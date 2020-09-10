<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190822195531 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633162A6DC27');

        $this->addSql('ALTER TABLE incident_detected ADD priority_id INT DEFAULT NULL');
        $this->addSql('UPDATE incident_detected SET incident_detected.priority_id = (select incident_priority.id from incident_priority where incident_priority.slug = incident_detected.priority)');

        $this->addSql('DROP INDEX IDX_F997633162A6DC27 ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected DROP priority');

        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F9976331497B19F9 FOREIGN KEY (priority_id) REFERENCES incident_priority (id)');
        $this->addSql('CREATE INDEX IDX_F9976331497B19F9 ON incident_detected (priority_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331497B19F9');
        $this->addSql('DROP INDEX IDX_F9976331497B19F9 ON incident_detected');
        $this->addSql('ALTER TABLE incident_detected ADD priority VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP priority_id');
        $this->addSql('ALTER TABLE incident_detected ADD CONSTRAINT FK_F997633162A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug)');
        $this->addSql('CREATE INDEX IDX_F997633162A6DC27 ON incident_detected (priority)');
    }
}
