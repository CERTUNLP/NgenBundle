<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190701205607 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE state_edge (id INT AUTO_INCREMENT NOT NULL, mail_assigned VARCHAR(45) DEFAULT NULL, mail_team VARCHAR(45) DEFAULT NULL, mail_admin VARCHAR(45) DEFAULT NULL, mail_reporter VARCHAR(45) DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, oldState VARCHAR(100) DEFAULT NULL, newState VARCHAR(100) DEFAULT NULL, discr VARCHAR(255) NOT NULL, INDEX IDX_E1E55AA017EA0C41 (oldState), INDEX IDX_E1E55AA0CB9A3939 (newState), INDEX IDX_E1E55AA0D64D0DD2 (mail_assigned), INDEX IDX_E1E55AA0699B3576 (mail_team), INDEX IDX_E1E55AA0BCCDAF19 (mail_admin), INDEX IDX_E1E55AA0AB0121BA (mail_reporter), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA017EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE state_edge ADD CONSTRAINT FK_E1E55AA0AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_state_edge (id INT AUTO_INCREMENT NOT NULL, mail_assigned VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_team VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_admin VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_reporter VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, oldState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, newState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_AF282D11D64D0DD2 (mail_assigned), INDEX IDX_AF282D11BCCDAF19 (mail_admin), INDEX IDX_AF282D1117EA0C41 (oldState), INDEX IDX_AF282D11699B3576 (mail_team), INDEX IDX_AF282D11AB0121BA (mail_reporter), INDEX IDX_AF282D11CB9A3939 (newState), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D1117EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('DROP TABLE state_edge');
    }
}
