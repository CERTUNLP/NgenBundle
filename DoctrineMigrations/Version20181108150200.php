<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181108150200 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_decision (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, feed VARCHAR(100) DEFAULT NULL, impact VARCHAR(45) DEFAULT NULL, urgency VARCHAR(45) DEFAULT NULL, tlp VARCHAR(45) DEFAULT NULL, state VARCHAR(100) DEFAULT NULL, INDEX IDX_7C69DA3B8CDE5729 (type), INDEX IDX_7C69DA3B234044AB (feed), INDEX IDX_7C69DA3BC409C007 (impact), INDEX IDX_7C69DA3B677C3782 (urgency), INDEX IDX_7C69DA3B62A6DC27 (tlp), INDEX IDX_7C69DA3BA393D2FB (state), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident_priority (slug VARCHAR(45) NOT NULL, name VARCHAR(255) NOT NULL, response_time CHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', resolution_time CHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', code INT NOT NULL, UNIQUE INDEX UNIQ_9A63B8545E237E06 (name), UNIQUE INDEX UNIQ_9A63B85477153098 (code), PRIMARY KEY(slug)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B8CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B234044AB FOREIGN KEY (feed) REFERENCES incident_feed (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BC409C007 FOREIGN KEY (impact) REFERENCES incident_impact (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B677C3782 FOREIGN KEY (urgency) REFERENCES incident_urgency (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B62A6DC27 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B62A6DC27');
        $this->addSql('DROP TABLE incident_decision');
        $this->addSql('DROP TABLE incident_priority');
    }
}
