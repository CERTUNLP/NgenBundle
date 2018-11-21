<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181121145047 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE network_entity (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, slug VARCHAR(100) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident CHANGE academic_unit_id network_entity_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_3D03A11A6801DB4 ON incident (network_entity_id)');
        $this->addSql('ALTER TABLE incident_tlp CHANGE description description VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE network CHANGE academic_unit_id network_entity_id INT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A6801DB4');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B812D5EB');
        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B727ACA70');
        $this->addSql('CREATE TABLE academic_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE network_entity');
        $this->addSql('DROP TABLE container_extension');
        $this->addSql('DROP TABLE container_parameter');
        $this->addSql('DROP TABLE container_config');
        $this->addSql('DROP INDEX IDX_3D03A11A6801DB4 ON incident');
        $this->addSql('ALTER TABLE incident CHANGE network_entity_id academic_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A7D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A7D33BAAB ON incident (academic_unit_id)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B35F44C09');
        $this->addSql('DROP INDEX idx_7c69da3b35f44c09 ON incident_decision');
        $this->addSql('CREATE INDEX IDX_7C69DA3B62A6DC27 ON incident_decision (tlp)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B35F44C09 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident_tlp CHANGE description description VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('DROP INDEX IDX_608487BC6801DB4 ON network');
        $this->addSql('ALTER TABLE network CHANGE network_entity_id academic_unit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC7D33BAAB FOREIGN KEY (academic_unit_id) REFERENCES academic_unit (id)');
        $this->addSql('CREATE INDEX IDX_608487BC7D33BAAB ON network (academic_unit_id)');
    }
}
