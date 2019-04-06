<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190406142130 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_state_action (slug VARCHAR(45) NOT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(250) DEFAULT NULL, open TINYINT(1) NOT NULL, close TINYINT(1) NOT NULL, re_open TINYINT(1) NOT NULL, PRIMARY KEY(slug)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql("INSERT INTO incident_state_action (`slug`, `name`, `description`, `open`, `close`, `re_open`) VALUES ('open and close', 'Open and Close', 'Open and Close and incident', '1', '1', '0')");
        $this->addSql("INSERT INTO incident_state_action (`slug`, `name`, `description`, `open`, `close`, `re_open`) VALUES ('open', 'Open', 'Open an incident', '1', '0', '0')");
        $this->addSql("INSERT INTO incident_state_action (`slug`, `name`, `description`, `open`, `close`, `re_open`) VALUES ('close', 'Close', 'Close and Incident', '0', '1', '0')");
        $this->addSql("INSERT INTO incident_state_action (`slug`, `name`, `description`, `open`, `close`, `re_open`) VALUES ('reopen', 'Reopen', 'Open a closed incident', '0', '0', '1')");
        $this->addSql("INSERT INTO incident_state_action (`slug`, `name`, `description`, `open`, `close`, `re_open`) VALUES ('new', 'New', 'New incident', '0', '0', '0')");
        $this->addSql("UPDATE incident_state SET `incident_state_action`='close' WHERE `slug`='closed'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='close' WHERE `slug`='closed_by_inactivity'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='open' WHERE `slug`='open'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='close' WHERE `slug`='removed'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='new' WHERE `slug`='sarasa'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='new' WHERE `slug`='staging'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='new' WHERE `slug`='stand_by'");
        $this->addSql("UPDATE `incident_state` SET `incident_state_action`='new' WHERE `slug`='undefined'");
        $this->addSql("UPDATE incident_state` SET `incident_state_action`='close' WHERE `slug`='unresolved'");
        $this->addSql('ALTER TABLE incident_state ADD incident_state_action VARCHAR(45) DEFAULT NULL, DROP is_opening, DROP is_closing');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091B8037C6C FOREIGN KEY (incident_state_action) REFERENCES incident_state_action (slug)');
        $this->addSql('CREATE INDEX IDX_F8A77091B8037C6C ON incident_state (incident_state_action)');
        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091B8037C6C');
        $this->addSql('DROP TABLE incident_state_action');
        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX IDX_F8A77091B8037C6C ON incident_state');
        $this->addSql('ALTER TABLE incident_state ADD is_opening TINYINT(1) NOT NULL, ADD is_closing TINYINT(1) NOT NULL, DROP incident_state_action');
    }
}
