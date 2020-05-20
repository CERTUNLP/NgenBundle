<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190110174203 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network ADD ip_v6_mask VARCHAR(40) DEFAULT NULL, CHANGE numeric_ip_v6 numeric_ip_v6 VARBINARY(16) DEFAULT NULL, CHANGE ip_mask ip_v4_mask VARCHAR(40) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network ADD ip_mask VARCHAR(40) DEFAULT NULL COLLATE utf8_unicode_ci, DROP ip_v4_mask, DROP ip_v6_mask, CHANGE numeric_ip_v6 numeric_ip_v6 INT UNSIGNED DEFAULT NULL');
    }
}
