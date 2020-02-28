<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20200114152627 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->connection->getDatabasePlatform()->registerDoctrineTypeMapping('ENUM', 'string');

        $this->addSql('ALTER TABLE communication_behavior DROP type, CHANGE mode mode ENUM(\'manual\',\'file\',\'data\', \'all\')');
        $this->addSql('ALTER TABLE incident_decision CHANGE when_to_update when_to_update VARCHAR(100)');
        $this->addSql('ALTER TABLE communication_behavior DROP COLUMN name');
        $this->addSql("INSERT INTO `communication_behavior` VALUES ('all',1,NULL,'2020-01-09 17:56:34','all'),('data',1,NULL,'2020-01-09 17:56:34','data'),('file',1,NULL,'2020-01-09 17:56:34','file'),('manual',1,NULL,'2020-01-09 17:56:34','manual')");
        $this->addSql('update incident_decision set communication_behavior_close="all", communication_behavior_new="all", communication_behavior_open="all",communication_behavior_summary="all",communication_behavior_update="all",when_to_update="live"');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE communication_behavior ADD type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE mode mode VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D59E53FB9');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F59E53FB9');
        $this->addSql('ALTER TABLE incident_decision CHANGE when_to_update when_to_update DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_detected DROP FOREIGN KEY FK_F997633159E53FB9');
    }
}
