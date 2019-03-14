<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190314135348 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A677C3782');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AC409C007');
        $this->addSql('DROP INDEX IDX_3D03A11AC409C007 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11A677C3782 ON incident');
        $this->addSql('ALTER TABLE incident ADD priority VARCHAR(255) DEFAULT NULL, DROP urgency, DROP impact');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A62A6DC27 FOREIGN KEY (priority) REFERENCES incident_priority (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11A62A6DC27 ON incident (priority)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A62A6DC27');
        $this->addSql('DROP INDEX IDX_3D03A11A62A6DC27 ON incident');
        $this->addSql('ALTER TABLE incident ADD urgency VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD impact VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, DROP priority');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A677C3782 FOREIGN KEY (urgency) REFERENCES incident_urgency (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11AC409C007 ON incident (impact)');
        $this->addSql('CREATE INDEX IDX_3D03A11A677C3782 ON incident (urgency)');
    }
}
