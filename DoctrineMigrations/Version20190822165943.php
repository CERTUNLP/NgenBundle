<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190822165943 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_priority DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE incident_priority ADD id INT NOT NULL');
        $this->addSql('ALTER TABLE incident_priority ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE incident_priority CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE incident_decision RENAME INDEX idx_7c69da3b7dc9d7a5 TO IDX_7C69DA3B3AA33DF6');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091B8037C6C');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision RENAME INDEX idx_7c69da3b3aa33df6 TO IDX_7C69DA3B7DC9D7A5');
        $this->addSql('ALTER TABLE incident_priority MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE incident_priority DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE incident_priority DROP id');
        $this->addSql('ALTER TABLE incident_priority ADD PRIMARY KEY (slug)');
    }
}
