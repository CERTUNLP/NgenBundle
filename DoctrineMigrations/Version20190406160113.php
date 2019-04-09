<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190406160113 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE incident_change_state (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, responsable_id INT DEFAULT NULL, date DATETIME DEFAULT NULL, method VARCHAR(25) NOT NULL, INDEX IDX_CCFC5A1D59E53FB9 (incident_id), INDEX IDX_CCFC5A1DA393D2FB (state), INDEX IDX_CCFC5A1D53C59D72 (responsable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D53C59D72 FOREIGN KEY (responsable_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE incident_change_state_history');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770917DB76696 FOREIGN KEY (incident_state_action) REFERENCES incident_state_action (slug)');
        $this->addSql('ALTER TABLE incident_state RENAME INDEX idx_f8a77091b8037c6c TO IDX_F8A770917DB76696');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_change_state_history (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, state VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, date DATETIME DEFAULT NULL, INDEX IDX_7D5CDF8DA393D2FB (state), INDEX IDX_7D5CDF8D59E53FB9 (incident_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE incident_change_state_history ADD CONSTRAINT FK_7D5CDF8D59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_change_state_history ADD CONSTRAINT FK_7D5CDF8DA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('DROP TABLE incident_change_state');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A770917DB76696');
        $this->addSql('ALTER TABLE incident_state RENAME INDEX idx_f8a770917db76696 TO IDX_F8A77091B8037C6C');
    }
}
