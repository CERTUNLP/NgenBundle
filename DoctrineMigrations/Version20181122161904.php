<?php

namespace Application\Migrations;

use Doctrine\Migrations\AbstractMigration;use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181122161904 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX IDX_3D03A11A7D33BAAB ON incident');
        $this->addSql("UPDATE network_entity SET `created_at`=CURRENT_TIMESTAMP() WHERE CAST(created_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE network_entity SET `updated_at`=CURRENT_TIMESTAMP() WHERE CAST(updated_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE network_admin SET `updated_at`=CURRENT_TIMESTAMP()  WHERE CAST(updated_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE network_admin SET `created_at`=CURRENT_TIMESTAMP() WHERE CAST(created_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE network SET `updated_at`=CURRENT_TIMESTAMP() WHERE CAST(updated_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE network SET `created_at`=CURRENT_TIMESTAMP() WHERE CAST(created_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE incident_feed SET `updated_at`=CURRENT_TIMESTAMP() WHERE CAST(updated_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql("UPDATE incident_feed SET `created_at`=CURRENT_TIMESTAMP() WHERE CAST(created_at AS CHAR(20))='0000-00-00 00:00:00'");
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B62A6DC27');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B62A6DC27 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A6801DB4');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A7D33BAAB FOREIGN KEY (network_entity_id) REFERENCES academic_unit (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A7D33BAAB ON incident (network_entity_id)');
        $this->addSql('ALTER TABLE incident_decision DROP FOREIGN KEY FK_7C69DA3B35F44C09');
        $this->addSql('DROP INDEX idx_7c69da3b35f44c09 ON incident_decision');
        $this->addSql('CREATE INDEX IDX_7C69DA3B62A6DC27 ON incident_decision (tlp)');
        $this->addSql('ALTER TABLE incident_decision ADD CONSTRAINT FK_7C69DA3B35F44C09 FOREIGN KEY (tlp) REFERENCES incident_tlp (slug)');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE network DROP FOREIGN KEY FK_608487BC6801DB4');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC7D33BAAB FOREIGN KEY (network_entity_id) REFERENCES academic_unit (id)');
        $this->addSql('DROP INDEX idx_608487bc6801db4 ON network');
        $this->addSql('CREATE INDEX IDX_608487BC7D33BAAB ON network (network_entity_id)');
        $this->addSql('ALTER TABLE network ADD CONSTRAINT FK_608487BC6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
    }
}
