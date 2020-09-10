<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190405164209 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_last_time_detected DROP INDEX UNIQ_B0FEF4C759E53FB9, ADD INDEX IDX_B0FEF4C759E53FB9 (incident_id)');
        $this->addSql('ALTER TABLE incident_state ADD is_closing TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_last_time_detected DROP INDEX IDX_B0FEF4C759E53FB9, ADD UNIQUE INDEX UNIQ_B0FEF4C759E53FB9 (incident_id)');
        $this->addSql('ALTER TABLE incident_state DROP is_closing');
    }
}
