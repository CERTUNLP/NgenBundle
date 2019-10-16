<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191015150036 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096CB03EE1E');
        $this->addSql('DROP INDEX IDX_66D22096CB03EE1E ON incident_type');
        $this->addSql('ALTER TABLE incident_type ADD taxonomyValue VARCHAR(255) DEFAULT NULL, DROP root_type');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
   $this->addSql('DROP INDEX IDX_66D22096E371859C ON incident_type');
        $this->addSql('ALTER TABLE incident_type ADD root_type VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, DROP taxonomyValue');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096CB03EE1E FOREIGN KEY (root_type) REFERENCES incident_type (slug)');
        $this->addSql('CREATE INDEX IDX_66D22096CB03EE1E ON incident_type (root_type)');

    }
}
