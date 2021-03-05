<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210305020859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE playbook (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(100) DEFAULT NULL, created_by_id INT DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1024) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_58AF4A045E237E06 (name), INDEX IDX_58AF4A048CDE5729 (type), INDEX IDX_58AF4A04B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE playbook ADD CONSTRAINT FK_58AF4A048CDE5729 FOREIGN KEY (type) REFERENCES incident_type (slug)');
        $this->addSql('ALTER TABLE playbook ADD CONSTRAINT FK_58AF4A04B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('DROP TABLE playbook');
    }
}
