<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181101193934 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tlp (idtlp INT AUTO_INCREMENT NOT NULL, slug VARCHAR(45) DEFAULT NULL, rgb VARCHAR(45) DEFAULT NULL, `when` VARCHAR(500) DEFAULT NULL, encrypt TINYINT(1) DEFAULT NULL, why VARCHAR(500) DEFAULT NULL, information VARCHAR(10) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, PRIMARY KEY(idtlp)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident ADD tlp_state VARCHAR(45) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_3D03A11AB8037C6C ON incident (tlp_state)');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE tlp');
 #       $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('DROP INDEX IDX_3D03A11AB8037C6C ON incident');
        $this->addSql('ALTER TABLE incident DROP tlp_state');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT NOT NULL');
    }
}
