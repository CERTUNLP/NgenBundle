<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190109190541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network ADD numeric_ip_v6_mask BIGINT UNSIGNED DEFAULT NULL, ADD numeric_ip_v6 INT UNSIGNED DEFAULT NULL, CHANGE numeric_ip_mask numeric_ip_v4_mask BIGINT UNSIGNED DEFAULT NULL, CHANGE numeric_ip numeric_ip_v4 INT UNSIGNED DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE network ADD numeric_ip_mask BIGINT UNSIGNED DEFAULT NULL, ADD numeric_ip INT UNSIGNED DEFAULT NULL, DROP numeric_ip_v4_mask, DROP numeric_ip_v4, DROP numeric_ip_v6_mask, DROP numeric_ip_v6');
    }
}
