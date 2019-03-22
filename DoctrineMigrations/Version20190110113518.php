<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190110113518 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contact_case (slug VARCHAR(45) NOT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(slug)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact CHANGE contact_case contact_case VARCHAR(45) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_4C62E63850F71BFB ON contact (contact_case)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contact_case');
        $this->addSql('DROP INDEX IDX_4C62E63850F71BFB ON contact');
        $this->addSql('ALTER TABLE contact CHANGE contact_case contact_case VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
