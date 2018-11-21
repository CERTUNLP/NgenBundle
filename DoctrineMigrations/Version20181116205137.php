<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181116205137 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision ADD slug VARCHAR(100) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B35F44C09');
        $this->addSql('ALTER TABLE incident_decision DROP slug');
        $this->addSql('CREATE INDEX IDX_7C69DA3B62A6DC27 ON incident_decision (tlp)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B35F44C09 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident_tlp CHANGE description description VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
