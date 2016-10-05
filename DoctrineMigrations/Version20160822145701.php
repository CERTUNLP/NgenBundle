<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 * ExternalReportMigration
 */
class Version20160822145701 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_3D03A11A989D9B62 ON incident');
        $this->addSql('ALTER TABLE incident ADD discr VARCHAR(255) NOT NULL DEFAULT "internal", ADD network VARCHAR(255) DEFAULT NULL, ADD network_admin VARCHAR(255) DEFAULT NULL, ADD network_admin_emails LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD network_entity VARCHAR(255) DEFAULT NULL, ADD start_address VARCHAR(255) DEFAULT NULL, ADD end_address VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, CHANGE host_address host_address VARCHAR(20) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP discr, DROP network, DROP network_admin, DROP network_admin_emails, DROP network_entity, DROP start_address, DROP end_address, DROP country, CHANGE host_address host_address VARCHAR(20) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D03A11A989D9B62 ON incident (slug)');
    }

}
