<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200108232748 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');

        $this->addSql('CREATE TABLE communication_behavior (slug VARCHAR(100) NOT NULL, name VARCHAR(100) NOT NULL, is_active TINYINT(1) NOT NULL, description VARCHAR(250) DEFAULT NULL, created_at DATETIME NOT NULL, inNew ENUM(\'manual\',\'file\',\'data\', \'all\'), inOpen ENUM(\'manual\',\'file\',\'data\', \'all\'), inUpdate ENUM(\'manual\',\'file\',\'data\', \'all\'), inSummary ENUM(\'manual\',\'file\',\'data\', \'all\'), PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_detected ADD when_to_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096E371859C');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(100) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F9976331B060C973');
        $this->addSql('DROP TABLE communication_behavior');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
        $this->addSql('ALTER TABLE incident_detected DROP when_to_update');
        $this->addSql('ALTER TABLE incident_type CHANGE taxonomyValue taxonomyValue VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_type RENAME INDEX idx_66d22096e371859c TO FK_66D22096E371859C');
    }
}
