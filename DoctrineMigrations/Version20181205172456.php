<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181205172456 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host CHANGE ip_v4 ip_v4 VARCHAR(15) DEFAULT NULL, CHANGE ip_v6 ip_v6 VARCHAR(39) DEFAULT NULL, CHANGE url url VARCHAR(39) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE host CHANGE ip_v4 ip_v4 VARCHAR(15) NOT NULL COLLATE utf8_unicode_ci, CHANGE ip_v6 ip_v6 VARCHAR(39) NOT NULL COLLATE utf8_unicode_ci, CHANGE url url VARCHAR(39) NOT NULL COLLATE utf8_unicode_ci');
    }
}
