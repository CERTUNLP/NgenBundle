<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190221161431 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host DROP ip_v6, CHANGE ip_v4 ip VARCHAR(39) DEFAULT NULL');
        $this->addSql('ALTER TABLE network ADD ip_start_address VARCHAR(255) DEFAULT NULL, ADD ip_end_address VARCHAR(255) DEFAULT NULL, DROP numeric_ip_v4_mask, DROP ip_v4, DROP numeric_ip_v4, DROP numeric_domain, DROP numeric_ip_v6_mask, DROP numeric_ip_v6, DROP ip_v6_mask, DROP ip_v6_start_address, DROP ip_v6_end_address, CHANGE ip_v4_mask ip_mask VARCHAR(40) DEFAULT NULL, CHANGE ip_v6 ip VARCHAR(39) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host ADD ip_v4 VARCHAR(15) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE ip ip_v6 VARCHAR(39) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE network ADD numeric_ip_v4_mask BIGINT UNSIGNED DEFAULT NULL, ADD ip_v4 VARCHAR(15) DEFAULT NULL COLLATE utf8_unicode_ci, ADD numeric_ip_v4 INT UNSIGNED DEFAULT NULL, ADD numeric_domain INT UNSIGNED DEFAULT NULL, ADD numeric_ip_v6_mask VARBINARY(16) DEFAULT NULL, ADD numeric_ip_v6 VARBINARY(16) DEFAULT NULL, ADD ip_v6_mask VARCHAR(3) DEFAULT NULL COLLATE utf8_unicode_ci, ADD ip_v6_start_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD ip_v6_end_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP ip_start_address, DROP ip_end_address, CHANGE ip_mask ip_v4_mask VARCHAR(40) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE ip ip_v6 VARCHAR(39) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
