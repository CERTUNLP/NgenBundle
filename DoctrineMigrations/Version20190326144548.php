<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190326144548 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC7D33BAAB');
        $this->addSql('DROP INDEX IDX_608487BC7D33BAAB ON network');
        $this->addSql('ALTER TABLE network ADD asn VARCHAR(255) DEFAULT NULL, CHANGE country country_code VARCHAR(2) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     * @throws AbortMigrationException
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network DROP asn, CHANGE country_code country VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE INDEX IDX_608487BC7D33BAAB ON network (network_entity_id)');
    }
}
