<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190822172425 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A62A6DC27');
        $this->addSql('DROP INDEX IDX_3D03A11A62A6DC27 ON incident');
        $this->addSql('ALTER TABLE incident ADD priority_id INT DEFAULT NULL, DROP priority');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A497B19F9 FOREIGN KEY (priority_id) REFERENCES incident_priority (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A497B19F9 ON incident (priority_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A497B19F9');
        $this->addSql('DROP INDEX IDX_3D03A11A497B19F9 ON incident');
        $this->addSql('ALTER TABLE incident ADD priority VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP priority_id');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A62A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11A62A6DC27 ON incident (priority)');
    }
}
