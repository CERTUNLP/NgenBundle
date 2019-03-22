<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190118204831 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AC409C007');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091D64D0DD2');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091699B3576');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091BCCDAF19');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091AB0121BA');
    }
}
