<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191008213150 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_type ADD root_type VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_type ADD CONSTRAINT FK_66D22096CB03EE1E FOREIGN KEY (root_type) REFERENCES incident_type (slug)');
        $this->addSql('CREATE INDEX IDX_66D22096CB03EE1E ON incident_type (root_type)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident_type DROP FOREIGN KEY FK_66D22096CB03EE1E');
        $this->addSql('DROP INDEX IDX_66D22096CB03EE1E ON incident_type');
        $this->addSql('ALTER TABLE incident_type DROP root_type');
    }
}
