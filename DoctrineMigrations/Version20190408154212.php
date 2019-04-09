<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190408154212 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DA393D2FB');
        $this->addSql('DROP INDEX IDX_CCFC5A1DA393D2FB ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state ADD action_applied VARCHAR(45) DEFAULT NULL, ADD oldState VARCHAR(100) DEFAULT NULL, CHANGE state newState VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DCB9A3939 FOREIGN KEY (newState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1D17EA0C41 FOREIGN KEY (oldState) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DFC5C7F77 FOREIGN KEY (action_applied) REFERENCES incident_state_action (slug)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state (newState)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state (oldState)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DFC5C7F77 ON incident_change_state (action_applied)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DCB9A3939');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1D17EA0C41');
        $this->addSql('ALTER TABLE incident_change_state DROP FOREIGN KEY FK_CCFC5A1DFC5C7F77');
        $this->addSql('DROP INDEX IDX_CCFC5A1DCB9A3939 ON incident_change_state');
        $this->addSql('DROP INDEX IDX_CCFC5A1D17EA0C41 ON incident_change_state');
        $this->addSql('DROP INDEX IDX_CCFC5A1DFC5C7F77 ON incident_change_state');
        $this->addSql('ALTER TABLE incident_change_state ADD state VARCHAR(100) DEFAULT NULL COLLATE utf8_unicode_ci, DROP action_applied, DROP newState, DROP oldState');
        $this->addSql('ALTER TABLE incident_change_state ADD CONSTRAINT FK_CCFC5A1DA393D2FB FOREIGN KEY (state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_CCFC5A1DA393D2FB ON incident_change_state (state)');
    }
}
