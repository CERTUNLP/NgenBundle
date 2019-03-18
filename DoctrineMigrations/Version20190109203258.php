<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190109203258 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state CHANGE mail_admin mail_admin VARCHAR(255) NOT NULL, CHANGE mail_reporter mail_reporter VARCHAR(255) NOT NULL, CHANGE mail_assigned mail_assigned VARCHAR(255) NOT NULL, CHANGE mail_team mail_team VARCHAR(255) NOT NULL');
        $this->addSql("UPDATE incident_state SET `mail_admin`='none', `mail_reporter`='none', `mail_assigned`='none', `mail_team`='none'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state CHANGE mail_assigned mail_assigned TINYINT(1) NOT NULL, CHANGE mail_team mail_team TINYINT(1) NOT NULL, CHANGE mail_admin mail_admin TINYINT(1) NOT NULL, CHANGE mail_reporter mail_reporter TINYINT(1) NOT NULL');
    }
}
