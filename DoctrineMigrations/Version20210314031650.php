<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210314031650 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phase (id INT AUTO_INCREMENT NOT NULL, playbook INT DEFAULT NULL, created_by_id INT DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1024) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_B1BDD6CB58AF4A04 (playbook), INDEX IDX_B1BDD6CBB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playbook (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, created_by_id INT DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1024) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_58AF4A045E237E06 (name), INDEX IDX_58AF4A048CDE5729 (type), INDEX IDX_58AF4A04B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, phase INT DEFAULT NULL, created_by_id INT DEFAULT NULL, suggested_time TIME NOT NULL, slug VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1024) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_527EDB25B1BDD6CB (phase), INDEX IDX_527EDB25B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CB58AF4A04 FOREIGN KEY (playbook) REFERENCES playbook (id)');
        $this->addSql('ALTER TABLE phase ADD CONSTRAINT FK_B1BDD6CBB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playbook ADD CONSTRAINT FK_58AF4A048CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE playbook ADD CONSTRAINT FK_58AF4A04B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B1BDD6CB FOREIGN KEY (phase) REFERENCES phase (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB25B1BDD6CB');
        $this->addSql('ALTER TABLE phase DROP FOREIGN KEY FK_B1BDD6CB58AF4A04');
        $this->addSql('DROP TABLE phase');
        $this->addSql('DROP TABLE playbook');
        $this->addSql('DROP TABLE task');
    }
}
