<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171211201650 extends AbstractMigration {

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_report (lang VARCHAR(2) NOT NULL, type VARCHAR(100) NOT NULL, slug VARCHAR(64) NOT NULL, problem LONGTEXT NOT NULL, derivated_problem LONGTEXT DEFAULT NULL, verification LONGTEXT DEFAULT NULL, recomendations LONGTEXT DEFAULT NULL, more_information LONGTEXT DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6913CB60989D9B62 (slug), INDEX IDX_6913CB608CDE5729 (type), PRIMARY KEY(lang, type)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_report ADD CONSTRAINT FK_6913CB608CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema) {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE incident_report');
        $this->addSql('ALTER TABLE academic_unit DROP created_at, DROP updated_at, DROP is_active');
    }

}
