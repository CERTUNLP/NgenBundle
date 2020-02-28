<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200108235644 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $this->addSql('ALTER TABLE communication_behavior CHANGE inNew inNew ENUM(\'manual\',\'file\',\'data\', \'all\'), CHANGE inOpen inOpen ENUM(\'manual\',\'file\',\'data\', \'all\'), CHANGE inUpdate inUpdate ENUM(\'manual\',\'file\',\'data\', \'all\'), CHANGE inSummary inSummary ENUM(\'manual\',\'file\',\'data\', \'all\')');
        $this->addSql('ALTER TABLE incident_type DROP INDEX FK_66D22096E371859C');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(100) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior CHANGE inNew inNew VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE inOpen inOpen VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE inUpdate inUpdate VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE inSummary inSummary VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX idx_66d22096e371859c TO FK_66D22096E371859C');
    }
}
