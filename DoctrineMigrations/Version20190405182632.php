<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190405182632 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_change_state_history (id INT AUTO_INCREMENT NOT NULL, incident_id INT DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, date DATETIME DEFAULT NULL, INDEX IDX_7D5CDF8D59E53FB9 (incident_id), INDEX IDX_7D5CDF8DA393D2FB (state), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_change_state_history ADD CONSTRAINT FK_7D5CDF8D59E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE incident_change_state_history ADD CONSTRAINT FK_7D5CDF8DA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state CHANGE is_new is_opening TINYINT(1) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE incident_change_state_history');
        $this->addSql('ALTER TABLE incident_state CHANGE is_opening is_new TINYINT(1) NOT NULL');
    }
}
