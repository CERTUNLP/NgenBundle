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

        $this->addSql('ALTER TABLE state_edge DROP FOREIGN KEY FK_E1E55AA017EA0C41');
        $this->addSql('ALTER TABLE state_edge DROP FOREIGN KEY FK_E1E55AA0CB9A3939');

        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (10,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","new_report","undefined","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (11,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","new_report","staging","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (12,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","new_report","open","opening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (13,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","discarted","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (14,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","open","opening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (15,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","undefined","staging","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (16,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","undefined","discarted","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (17,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","open","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (18,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","unresolved","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (19,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","reassigned","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (20,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (21,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","closed_by_inactivity","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (22,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (23,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","unresolved","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (24,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","unresolved","closed_by_inactivity","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (25,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","unresolved","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (26,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","reassigned","open","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (27,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","reassigned","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (28,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","reassigned","closed_by_inactivity","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (29,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","reassigned","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (30,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","closed_by_inactivity","open","reopening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (31,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","discarted_by_inactivity","open","reopening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (32,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","staging","initializing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (33,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","new_report","initializing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (34,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","undefined","initializing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (35,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","open","opening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (36,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (37,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (38,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","initial","stand_by","initializing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (39,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","discarded-by-unsolved","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (40,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","open","discarded-by-unattended","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (41,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","staging","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (42,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","stand_by","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (43,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","undefined","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (44,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","discarded_by_unattended","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (45,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","discarded_by_innactivity","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (46,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","removed","removed","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (47,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","removed","staging","reopening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (48,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","removed","discarding")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (49,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","closed","staging","reopening")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (50,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","closed","closed","updating")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (51,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","staging","closed","closing")');
        $this->addSql('INSERT INTO `state_edge` (`id`,`mail_assigned`,`mail_team`,`mail_admin`,`mail_reporter`,`is_active`,`created_at`,`updated_at`,`oldState`,`newState`,`discr`) VALUES (52,"all","all","all","all",1,"2019-06-12 17:04:56","2019-06-12 17:04:56","stand_by","closed","closing")');

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
