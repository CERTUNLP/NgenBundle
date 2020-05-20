<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181204175508 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP ip');
        $this->addSql('ALTER TABLE network DROP abuse_entity, DROP abuse_entity_emails');
        $this->addSql('UPDATE network_admin SET email =CONCAT(\'a:1:{i:0;s:\',CHAR_LENGTH(email), \':"\', email, \'";}\') ');
        $this->addSql('ALTER TABLE network_admin CHANGE email emails LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD ip VARCHAR(15) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE network ADD abuse_entity VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD abuse_entity_emails LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE network_admin ADD email VARCHAR(150) NOT NULL COLLATE utf8_unicode_ci');
    }
}
