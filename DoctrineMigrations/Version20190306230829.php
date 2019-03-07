<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190306230829 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, data JSON NOT NULL COMMENT \'(DC2Type:json_array)\', updated_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, response VARCHAR(255) DEFAULT NULL, pending TINYINT(1) DEFAULT NULL, incident_id INT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('INSERT INTO message (id, data, updated_at, created_at, response, pending, incident_id, discr) VALUES (\'1\', \'{"type":"Tipo de Incidente", "address": "Host","state":"Open","tlp":"RED","date": "2019-03-03","risk": "HIGH","token":"730202758:AAHfX_iv3MlPkEREPNMocYwBVkiMd1UJjGw","chatid": "-321569464"}\', now(), now(), null, 1, 1, \'telegram\');');
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

        $this->addSql('DROP TABLE message');
        $this->addSql('ALTER TABLE acl_classes CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_entries CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_object_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE acl_security_identities CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL');
    }
}
