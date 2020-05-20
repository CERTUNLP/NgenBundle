<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181106144324 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tlp MODIFY idtlp INT NOT NULL');
        $this->addSql('ALTER TABLE tlp DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE tlp ADD name VARCHAR(45) DEFAULT NULL, DROP idtlp, CHANGE slug slug VARCHAR(45) NOT NULL');
        $this->addSql('ALTER TABLE tlp ADD PRIMARY KEY (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B812D5EB');
        $this->addSql('ALTER TABLE container_config DROP FOREIGN KEY FK_C89BC17B727ACA70');
        $this->addSql('DROP TABLE container_extension');
        $this->addSql('DROP TABLE container_parameter');
        $this->addSql('DROP TABLE container_config');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('ALTER TABLE tlp DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE tlp ADD idtlp INT AUTO_INCREMENT NOT NULL, DROP name, CHANGE slug slug VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE tlp ADD PRIMARY KEY (idtlp)');
    }
}
