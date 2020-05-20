<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190817155236 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
        $this->addSql('ALTER TABLE incident_state_behavior rename to state_behavior');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770913BABA0B0 FOREIGN KEY (behavior) REFERENCES state_behavior (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('CREATE TABLE incident_state_behavior (slug VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(250) DEFAULT NULL COLLATE utf8_unicode_ci, can_edit_fundamentals TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, can_edit TINYINT(1) NOT NULL, can_enrich TINYINT(1) NOT NULL, can_add_history TINYINT(1) NOT NULL, can_comunicate TINYINT(1) NOT NULL, discr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE state_behavior');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770913BABA0B0');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770913BABA0B0 FOREIGN KEY (behavior) REFERENCES incident_state_behavior (slug)');
    }
}
