<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170508191633 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD username_canonical VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE email email VARCHAR(180) NOT NULL, CHANGE username username VARCHAR(180) NOT NULL, CHANGE salt salt VARCHAR(255) DEFAULT NULL, CHANGE is_active enabled TINYINT(1) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64992FC23A8 ON user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649A0D96FBF ON user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649C05FB297 ON user (confirmation_token)');
        $this->addSql('ALTER TABLE incident_type CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE incident_state CHANGE is_active is_active TINYINT(1) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_3D03A11A989D9B62 ON incident');
        $this->addSql('ALTER TABLE incident_feed CHANGE is_active is_active TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D03A11A989D9B62 ON incident (slug)');
        $this->addSql('ALTER TABLE incident_feed CHANGE is_active is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE incident_state CHANGE is_active is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('ALTER TABLE incident_type CHANGE is_active is_active TINYINT(1) DEFAULT \'1\' NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8D93D64992FC23A8 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649A0D96FBF ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649C05FB297 ON user');
        $this->addSql('ALTER TABLE user DROP username_canonical, DROP email_canonical, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles, CHANGE username username VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE email email VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE enabled is_active TINYINT(1) NOT NULL');
    }
}
