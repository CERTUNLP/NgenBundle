<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190110140618 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contact_case ADD level INT NOT NULL');
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('Dont contact me', 'none', 'Never use this contact',0)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('Only Critical', 'critical', 'Only critical',1)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('From High', 'high', 'High and worst',2)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('From Medium', 'medium', 'Medium and worst',3)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('From Low', 'low', 'Low and worst',4)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('All', 'all', 'Send all the problems',5)");
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

        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE contact_case DROP level');
    }
}
