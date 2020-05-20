<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190731213117 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident_decision ADD unattended_state VARCHAR(100) DEFAULT NULL, ADD unsolved_state VARCHAR(100) DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_7C69DA3B7DC9D7A5 ON incident_decision (unattended_state)');
        $this->addSql('CREATE INDEX IDX_7C69DA3BEC6344B7 ON incident_decision (unsolved_state)');
        $this->addSql('ALTER TABLE incident ADD unattended_state VARCHAR(100) DEFAULT NULL, ADD unsolved_state VARCHAR(100) DEFAULT NULL');
        $this->addSql('UPDATE incident set unattended_state="discarded_by_unattended", unsolved_state="closed_by_inactivity"');
        $this->addSql('UPDATE incident_decision set unattended_state="discarded_by_unattended", unsolved_state="closed_by_unsolved"');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A3AA33DF6 FOREIGN KEY (unattended_state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AEC6344B7 FOREIGN KEY (unsolved_state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B7DC9D7A5 FOREIGN KEY (unattended_state) REFERENCES incident_state (slug)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3BEC6344B7 FOREIGN KEY (unsolved_state) REFERENCES incident_state (slug)');
        $this->addSql('CREATE INDEX IDX_3D03A11A3AA33DF6 ON incident (unattended_state)');
        $this->addSql('CREATE INDEX IDX_3D03A11AEC6344B7 ON incident (unsolved_state)');


    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A3AA33DF6');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AEC6344B7');
        $this->addSql('DROP INDEX IDX_3D03A11A3AA33DF6 ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11AEC6344B7 ON incident');
        $this->addSql('ALTER TABLE incident DROP unattended_state, DROP unsolved_state');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B7DC9D7A5');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3BEC6344B7');
        $this->addSql('DROP INDEX IDX_7C69DA3B7DC9D7A5 ON incident_decision');
        $this->addSql('DROP INDEX IDX_7C69DA3BEC6344B7 ON incident_decision');
        $this->addSql('ALTER TABLE incident_decision DROP unattended_state, DROP unsolved_state');


    }
}
