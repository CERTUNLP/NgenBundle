<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181107154751 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_impact (slug VARCHAR(45) NOT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident_urgency (slug VARCHAR(45) NOT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tlp RENAME TO incident_tlp ;');
        $this->addSql('ALTER TABLE incident ADD asigned_id INT DEFAULT NULL, ADD urgency VARCHAR(45) DEFAULT NULL, ADD impact VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11ADB5CDBB2 FOREIGN KEY (asigned_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A677C3782 FOREIGN KEY (urgency) REFERENCES incident_urgency (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11ADB5CDBB2 ON incident (asigned_id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A677C3782 ON incident (urgency)');
        $this->addSql('CREATE INDEX IDX_3D03A11AC409C007 ON incident (impact)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AC409C007');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A677C3782');
        $this->addSql('CREATE TABLE tlp (slug VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, rgb VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, `when` VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci, encrypt TINYINT(1) DEFAULT NULL, why VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci, information VARCHAR(10) DEFAULT NULL COLLATE utf8_unicode_ci, description VARCHAR(150) DEFAULT NULL COLLATE utf8_unicode_ci, name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE incident_impact');
        $this->addSql('ALTER TABLE incident_tlp RENAME TO tlp ;');
        $this->addSql('DROP TABLE incident_urgency');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11ADB5CDBB2');
        $this->addSql('DROP INDEX IDX_3D03A11ADB5CDBB2 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11A677C3782 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AC409C007 ON incident');
        $this->addSql('ALTER TABLE incident DROP asigned_id, DROP urgency, DROP impact');
    }
}
