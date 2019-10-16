<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191015234804 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taxonomy_predicate (slug VARCHAR(100) NOT NULL, description VARCHAR(1024) NOT NULL, expanded VARCHAR(255) NOT NULL, version INT NOT NULL, value VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_28010D241D775834 (value), PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxonomy_value (slug VARCHAR(100) NOT NULL, description VARCHAR(1024) NOT NULL, expanded VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, version INT NOT NULL, taxonomyPredicate VARCHAR(100) DEFAULT NULL, UNIQUE INDEX UNIQ_48109C991D775834 (value), INDEX IDX_48109C9931CA456F (taxonomyPredicate), PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE taxonomy_value ADD CONSTRAINT FK_48109C9931CA456F FOREIGN KEY (taxonomyPredicate) REFERENCES taxonomy_predicate (slug)');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096E371859C FOREIGN KEY (taxonomyValue) REFERENCES taxonomy_value (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE taxonomy_value DROP FOREIGN KEY FK_48109C9931CA456F');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096E371859C');
        $this->addSql('DROP TABLE taxonomy_predicate');
        $this->addSql('DROP TABLE taxonomy_value');
    }
}
