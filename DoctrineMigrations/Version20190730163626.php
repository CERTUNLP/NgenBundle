<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190730163626 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AA393D2FB');
        $this->addSql('DROP INDEX IDX_3D03A11AA393D2FB ON incident');
        $this->addSql('ALTER TABLE incident ADD state_edge_id INT DEFAULT NULL, DROP state');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A2F0D3B98 FOREIGN KEY (state_edge_id) REFERENCES state_edge (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A2F0D3B98 ON incident (state_edge_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D1117EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A2F0D3B98');
        $this->addSql('DROP INDEX IDX_3D03A11A2F0D3B98 ON incident');
        $this->addSql('ALTER TABLE incident ADD state VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, DROP state_edge_id');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11AA393D2FB ON incident (state)');
    }
}
