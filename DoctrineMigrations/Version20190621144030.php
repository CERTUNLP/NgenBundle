<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190621144030 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state_edge ADD mail_assigned VARCHAR(45) DEFAULT NULL, ADD mail_team VARCHAR(45) DEFAULT NULL, ADD mail_admin VARCHAR(45) DEFAULT NULL, ADD mail_reporter VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('CREATE INDEX IDX_AF282D11D64D0DD2 ON incident_state_edge (mail_assigned)');
        $this->addSql('CREATE INDEX IDX_AF282D11699B3576 ON incident_state_edge (mail_team)');
        $this->addSql('CREATE INDEX IDX_AF282D11BCCDAF19 ON incident_state_edge (mail_admin)');
        $this->addSql('CREATE INDEX IDX_AF282D11AB0121BA ON incident_state_edge (mail_reporter)');
        $this->addSql('ALTER TABLE incident_state_behavior  ADD is_new TINYINT(1) NOT NULL, change can_open is_open TINYINT(1) NOT NULL, CHANGE can_close is_closed TINYINT(1) NOT NULL, CHANGE can_re_open is_re_open TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091699B3576');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091AB0121BA');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091BCCDAF19');
        $this->addSql('ALTER TABLE incident_state DROP FOREIGN KEY FK_F8A77091D64D0DD2');
        $this->addSql('DROP INDEX IDX_F8A77091D64D0DD2 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091BCCDAF19 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091699B3576 ON incident_state');
        $this->addSql('DROP INDEX IDX_F8A77091AB0121BA ON incident_state');
        $this->addSql('ALTER TABLE incident_state DROP mail_admin, DROP mail_reporter, DROP mail_assigned, DROP mail_team');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_state ADD mail_admin VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD mail_reporter VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD mail_assigned VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD mail_team VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD old_edges_id INT DEFAULT NULL, ADD new_edges_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A770914D6109E2 FOREIGN KEY (old_edges_id) REFERENCES incident_state_edge (id)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091611041E3 FOREIGN KEY (new_edges_id) REFERENCES incident_state_edge (id)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state ADD CONSTRAINT FK_F8A77091D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('CREATE INDEX IDX_F8A77091611041E3 ON incident_state (new_edges_id)');
        $this->addSql('CREATE INDEX IDX_F8A77091D64D0DD2 ON incident_state (mail_assigned)');
        $this->addSql('CREATE INDEX IDX_F8A77091BCCDAF19 ON incident_state (mail_admin)');
        $this->addSql('CREATE INDEX IDX_F8A770914D6109E2 ON incident_state (old_edges_id)');
        $this->addSql('CREATE INDEX IDX_F8A77091699B3576 ON incident_state (mail_team)');
        $this->addSql('CREATE INDEX IDX_F8A77091AB0121BA ON incident_state (mail_reporter)');
        $this->addSql('ALTER TABLE incident_state_behavior ADD can_open TINYINT(1) NOT NULL, ADD can_close TINYINT(1) NOT NULL, ADD can_re_open TINYINT(1) NOT NULL, DROP is_open, DROP is_closed, DROP is_re_open, DROP is_new, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE incident_state_edge DROP FOREIGN KEY FK_AF282D11D64D0DD2');
        $this->addSql('ALTER TABLE incident_state_edge DROP FOREIGN KEY FK_AF282D11699B3576');
        $this->addSql('ALTER TABLE incident_state_edge DROP FOREIGN KEY FK_AF282D11BCCDAF19');
        $this->addSql('ALTER TABLE incident_state_edge DROP FOREIGN KEY FK_AF282D11AB0121BA');
        $this->addSql('DROP INDEX IDX_AF282D11D64D0DD2 ON incident_state_edge');
        $this->addSql('DROP INDEX IDX_AF282D11699B3576 ON incident_state_edge');
        $this->addSql('DROP INDEX IDX_AF282D11BCCDAF19 ON incident_state_edge');
        $this->addSql('DROP INDEX IDX_AF282D11AB0121BA ON incident_state_edge');
        $this->addSql('ALTER TABLE incident_state_edge DROP mail_assigned, DROP mail_team, DROP mail_admin, DROP mail_reporter');
    }
}
