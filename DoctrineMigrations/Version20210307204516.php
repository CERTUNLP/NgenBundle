<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210307204516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE playbook_element (id INT AUTO_INCREMENT NOT NULL, parent INT DEFAULT NULL, created_by_id INT DEFAULT NULL, playbook INT DEFAULT NULL, slug VARCHAR(100) DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1024) NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, deletedAt DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, suggested_time TIME DEFAULT NULL, UNIQUE INDEX UNIQ_B110BCB85E237E06 (name), INDEX IDX_B110BCB83D8E604F (parent), INDEX IDX_B110BCB8B03A8386 (created_by_id), INDEX IDX_B110BCB858AF4A04 (playbook), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE playbook_element ADD CONSTRAINT FK_B110BCB83D8E604F FOREIGN KEY (parent) REFERENCES playbook_element (id)');
        $this->addSql('ALTER TABLE playbook_element ADD CONSTRAINT FK_B110BCB8B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playbook_element ADD CONSTRAINT FK_B110BCB858AF4A04 FOREIGN KEY (playbook) REFERENCES playbook (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE playbook_element DROP FOREIGN KEY FK_B110BCB83D8E604F');
        $this->addSql('DROP TABLE playbook_element');
    }
}
