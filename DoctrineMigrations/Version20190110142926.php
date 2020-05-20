<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190110142926 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state CHANGE mail_admin mail_admin VARCHAR(45) DEFAULT NULL, CHANGE mail_reporter mail_reporter VARCHAR(45) DEFAULT NULL, CHANGE mail_assigned mail_assigned VARCHAR(45) DEFAULT NULL, CHANGE mail_team mail_team VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('CREATE INDEX IDX_F8A77091D64D0DD2 ON incident_state (mail_assigned)');
        $this->addSql('CREATE INDEX IDX_F8A77091699B3576 ON incident_state (mail_team)');
        $this->addSql('CREATE INDEX IDX_F8A77091BCCDAF19 ON incident_state (mail_admin)');
        $this->addSql('CREATE INDEX IDX_F8A77091AB0121BA ON incident_state (mail_reporter)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091D64D0DD2');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091699B3576');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091BCCDAF19');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091AB0121BA');
        $this->addSql('DROP INDEX IDX_F8A77091D64D0DD2 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091699B3576 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091BCCDAF19 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091AB0121BA ON incident_state');
        $this->addSql('ALTER TABLE incident_state CHANGE mail_assigned mail_assigned VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE mail_team mail_team VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE mail_admin mail_admin VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE mail_reporter mail_reporter VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
