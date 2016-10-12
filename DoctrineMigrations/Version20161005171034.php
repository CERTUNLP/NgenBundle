<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161005171034 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD abuse_entity VARCHAR(255) DEFAULT NULL, DROP network, DROP network_admin, CHANGE discr discr VARCHAR(255) NOT NULL, CHANGE network_admin_emails abuse_entity_emails LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD network_admin VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE discr discr VARCHAR(255) DEFAULT \'internal\' NOT NULL COLLATE utf8_unicode_ci, CHANGE abuse_entity network VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE abuse_entity_emails network_admin_emails LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\'');
    }
}
