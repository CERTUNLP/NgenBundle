<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150629160119 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE IncidentCommentThread (id VARCHAR(255) NOT NULL, incident_id INT DEFAULT NULL, permalink VARCHAR(255) NOT NULL, is_commentable TINYINT(1) NOT NULL, num_comments INT NOT NULL, last_comment_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_587C04F759E53FB9 (incident_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE IncidentComment (id INT AUTO_INCREMENT NOT NULL, thread_id VARCHAR(255) DEFAULT NULL, author_id INT DEFAULT NULL, body LONGTEXT NOT NULL, ancestors VARCHAR(1024) NOT NULL, depth INT NOT NULL, created_at DATETIME NOT NULL, state INT NOT NULL, INDEX IDX_87030E09E2904019 (thread_id), INDEX IDX_87030E09F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE IncidentCommentThread ADD CONSTRAINT FK_587C04F759E53FB9 FOREIGN KEY (incident_id) REFERENCES Incident (id)');
        $this->addSql('ALTER TABLE IncidentComment ADD CONSTRAINT FK_87030E09E2904019 FOREIGN KEY (thread_id) REFERENCES IncidentCommentThread (id)');
        $this->addSql('ALTER TABLE IncidentComment ADD CONSTRAINT FK_87030E09F675F31B FOREIGN KEY (author_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Incident ADD report_message_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C475C34C989D9B62 ON Incident (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE IncidentComment DROP FOREIGN KEY FK_87030E09E2904019');
        $this->addSql('DROP TABLE IncidentCommentThread');
        $this->addSql('DROP TABLE IncidentComment');
        $this->addSql('DROP INDEX UNIQ_C475C34C989D9B62 ON Incident');
        $this->addSql('ALTER TABLE Incident DROP report_message_id');
    }
}
