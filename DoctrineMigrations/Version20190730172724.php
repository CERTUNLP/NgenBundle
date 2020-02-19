<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190730172724 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE incident_state_edge');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D17EA0C41');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DFC5C7F77');
//        $this->addSql('DROP INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state');
        $this->addSql('DROP INDEX IDX_CCFC5A1DFC5C7F77 ON incident_change_state');
//        $this->addSql('DROP INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state ADD state_edge_id INT DEFAULT NULL, DROP action_applied');
//        TODO: aca buscar los edges para cada change state

        $this->addSql('UPDATE incident_change_state SET incident_change_state.state_edge_id = (select state_edge.id from state_edge where state_edge.newState = incident_change_state.newState and  state_edge.oldState = incident_change_state.oldState )');
        $this->addSql('UPDATE incident_change_state SET incident_change_state.state_edge_id = (select state_edge.id from state_edge where state_edge.newState = incident_change_state.newState and  state_edge.oldState = "initial" and  incident_change_state.oldState is null ) where incident_change_state.state_edge_id is null');

 //       $this->addSql('ALTER TABLE incident_change_state DROP newState, DROP oldState');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D2F0D3B98 FOREIGN KEY (state_edge_id) REFERENCES state_edge (id)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1D2F0D3B98 ON incident_change_state (state_edge_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE incident_state_edge (id INT AUTO_INCREMENT NOT NULL, mail_assigned VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_team VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_admin VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, mail_reporter VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, is_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, oldState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, newState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_AF282D1117EA0C41 (oldState), INDEX IDX_AF282D11D64D0DD2 (mail_assigned), INDEX IDX_AF282D11BCCDAF19 (mail_admin), INDEX IDX_AF282D11CB9A3939 (newState), INDEX IDX_AF282D11699B3576 (mail_team), INDEX IDX_AF282D11AB0121BA (mail_reporter), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D1117EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11699B3576 FOREIGN KEY (mail_team) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11AB0121BA FOREIGN KEY (mail_reporter) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11BCCDAF19 FOREIGN KEY (mail_admin) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11CB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_state_edge ADD CONSTRAINT FK_AF282D11D64D0DD2 FOREIGN KEY (mail_assigned) REFERENCES contact_case (slug)');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D2F0D3B98');
        $this->addSql('DROP INDEX IDX_CCFC5A1D2F0D3B98 ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state ADD action_applied VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, ADD newState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, ADD oldState VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, DROP state_edge_id');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D17EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DCB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DFC5C7F77 FOREIGN KEY (action_applied) REFERENCES incident_state_behavior (slug)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state (newState)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DFC5C7F77 ON incident_change_state (action_applied)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state (oldState)');
    }
}
