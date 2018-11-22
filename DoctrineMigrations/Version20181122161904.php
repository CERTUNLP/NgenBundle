<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181122161904 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A7D33BAAB');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC7D33BAAB');
        $this->addSql('DROP TABLE academic_unit');
        $this->addSql('DROP INDEX IDX_3D03A11A7D33BAAB ON incident');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B62A6DC27');
        $this->addSql('DROP INDEX idx_7c69da3b62a6dc27 ON incident_decision');
        $this->addSql('CREATE INDEX IDX_7C69DA3B35F44C09 ON incident_decision (tlp)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B62A6DC27 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');

        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
        $this->addSql('CREATE INDEX IDX_608487BC6801DB4 ON network (network_entity_id)');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC7D33BAAB FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B812D5EB');
        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B727ACA70');
        $this->addSql('CREATE TABLE academic_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, slug VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE container_extension');
        $this->addSql('DROP TABLE container_parameter');
        $this->addSql('DROP TABLE container_config');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A6801DB4');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A7D33BAAB FOREIGN KEY (network_entity_id) REFERENCES academic_unit (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A7D33BAAB ON incident (network_entity_id)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B35F44C09');
        $this->addSql('DROP INDEX idx_7c69da3b35f44c09 ON incident_decision');
        $this->addSql('CREATE INDEX IDX_7C69DA3B62A6DC27 ON incident_decision (tlp)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B35F44C09 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC7D33BAAB FOREIGN KEY (network_entity_id) REFERENCES academic_unit (id)');
        $this->addSql('DROP INDEX idx_608487bc6801db4 ON network');
        $this->addSql('CREATE INDEX IDX_608487BC7D33BAAB ON network (network_entity_id)');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
    }
}
