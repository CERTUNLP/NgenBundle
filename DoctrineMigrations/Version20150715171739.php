<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150715171739 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Incident ADD academicUnit_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Incident ADD CONSTRAINT FK_C475C34C25C9D040 FOREIGN KEY (academicUnit_id) REFERENCES AcademicUnit (id)');
        $this->addSql('CREATE INDEX IDX_C475C34C25C9D040 ON Incident (academicUnit_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Incident DROP FOREIGN KEY FK_C475C34C25C9D040');
        $this->addSql('DROP INDEX IDX_C475C34C25C9D040 ON Incident');
        $this->addSql('ALTER TABLE Incident DROP academicUnit_id');
    }
}
