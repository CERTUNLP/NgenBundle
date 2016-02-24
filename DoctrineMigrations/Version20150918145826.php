<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150918145826 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment DROP FOREIGN KEY FK_33BE48B163379586');
        $this->addSql('DROP INDEX IDX_33BE48B163379586 ON incident_comment');
        $this->addSql('ALTER TABLE incident_comment CHANGE comments_id thread_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment ADD CONSTRAINT FK_33BE48B1E2904019 FOREIGN KEY (thread_id) REFERENCES incident_comment_thread (id)');
        $this->addSql('CREATE INDEX IDX_33BE48B1E2904019 ON incident_comment (thread_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_comment DROP FOREIGN KEY FK_33BE48B1E2904019');
        $this->addSql('DROP INDEX IDX_33BE48B1E2904019 ON incident_comment');
        $this->addSql('ALTER TABLE incident_comment CHANGE thread_id comments_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment ADD CONSTRAINT FK_33BE48B163379586 FOREIGN KEY (comments_id) REFERENCES incident_comment_thread (id)');
        $this->addSql('CREATE INDEX IDX_33BE48B163379586 ON incident_comment (comments_id)');
    }
}
