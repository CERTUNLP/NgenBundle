<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181106135234 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES tlp (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11AB8037C6C ON incident (tlp_state)');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT AUTO_INCREMENT NOT NULL, CHANGE description description VARCHAR(45) DEFAULT NULL, CHANGE name slug VARCHAR(45) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('DROP INDEX IDX_3D03A11AB8037C6C ON incident');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT NOT NULL, CHANGE description description VARCHAR(150) DEFAULT NULL COLLATE latin1_swedish_ci, CHANGE slug name VARCHAR(45) DEFAULT NULL COLLATE latin1_swedish_ci');
    }
}
