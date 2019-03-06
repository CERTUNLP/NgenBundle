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
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('none','Dont contact me', 'Never use this contact',0)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('critical', 'Only Critical',  'Only critical',1)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('high', 'From High',  'High and worst',2)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('medium', 'From Medium',  'Medium and worst',3)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ( 'low', 'From Low', 'Low and worst',4)");
        $this->addSql("INSERT INTO contact_case (`slug`, `name`, `description`,`level`) VALUES ('all', 'All','Send all the problems',5)");
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
