<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181203143328 extends AbstractMigration
{
    /**
     * @param Schema $schema
     * @throws \Doctrine\DBAL\Migrations\AbortMigrationException
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE host (id INT AUTO_INCREMENT NOT NULL, network_id INT DEFAULT NULL, ip_v4 VARCHAR(15) NOT NULL, ip_v6 VARCHAR(39) NOT NULL, url VARCHAR(39) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(100) DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_CF2713FD34128B91 (network_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE host ADD CONSTRAINT FK_CF2713FD34128B91 FOREIGN KEY (network_id) REFERENCES network (id)');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A6801DB4');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AC9E8B981');
        $this->addSql('DROP INDEX IDX_3D03A11AC9E8B981 ON incident');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A7D33BAAB');
        $this->addSql('ALTER TABLE incident ADD origin_id INT DEFAULT NULL, ADD destination_id INT DEFAULT NULL, ADD ip VARCHAR(15) NOT NULL, DROP network_admin_id, DROP network_entity_id, DROP discr, DROP abuse_entity, DROP abuse_entity_emails, DROP network_entity, DROP start_address, DROP end_address, DROP country, CHANGE notes notes LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A56A273CC FOREIGN KEY (origin_id) REFERENCES host (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A816C6140 FOREIGN KEY (destination_id) REFERENCES host (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A56A273CC ON incident (origin_id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A816C6140 ON incident (destination_id)');
        $this->addSql('ALTER TABLE incident_comment_thread ADD host_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident_comment_thread ADD CONSTRAINT FK_E073862F1FB8D185 FOREIGN KEY (host_id) REFERENCES host (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread (host_id)');
        $this->addSql('ALTER TABLE network  ADD ip_v6 VARCHAR(39) NOT NULL, ADD url VARCHAR(39) NOT NULL, ADD discr VARCHAR(255) NOT NULL, ADD abuse_entity VARCHAR(255) DEFAULT NULL, ADD abuse_entity_emails LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', ADD start_address VARCHAR(255) DEFAULT NULL, ADD end_address VARCHAR(255) DEFAULT NULL, ADD country VARCHAR(255) DEFAULT NULL, change ip ip_v4 VARCHAR(15) NOT NULL');
        $this->addSql("UPDATE network SET `discr`='internal'");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A56A273CC');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11A816C6140');
        $this->addSql('ALTER TABLE incident_comment_thread DROP FOREIGN KEY FK_E073862F1FB8D185');
        $this->addSql('DROP TABLE host');
        $this->addSql('DROP INDEX IDX_3D03A11A56A273CC ON incident');
        $this->addSql('DROP INDEX IDX_3D03A11A816C6140 ON incident');
        $this->addSql('ALTER TABLE incident ADD network_admin_id INT DEFAULT NULL, ADD network_entity_id INT DEFAULT NULL, ADD discr VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD host_address VARCHAR(20) DEFAULT NULL COLLATE utf8_unicode_ci, ADD abuse_entity VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD abuse_entity_emails LONGTEXT DEFAULT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', ADD network_entity VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD start_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD end_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD country VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP origin_id, DROP destination_id, DROP ip, CHANGE notes notes VARCHAR(500) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11A6801DB4 FOREIGN KEY (network_entity_id) REFERENCES network_entity (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AC9E8B981 FOREIGN KEY (network_admin_id) REFERENCES network_admin (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11AC9E8B981 ON incident (network_admin_id)');
        $this->addSql('CREATE INDEX IDX_3D03A11A6801DB4 ON incident (network_entity_id)');
        $this->addSql('DROP INDEX UNIQ_E073862F1FB8D185 ON incident_comment_thread');
        $this->addSql('ALTER TABLE incident_comment_thread DROP host_id');
        $this->addSql('ALTER TABLE network ADD ip VARCHAR(40) NOT NULL COLLATE utf8_unicode_ci, DROP ip_v4, DROP ip_v6, DROP url, DROP discr, DROP abuse_entity, DROP abuse_entity_emails, DROP start_address, DROP end_address, DROP country');
        $this->addSql('CREATE INDEX IDX_608487BC7D33BAAB ON network (network_entity_id)');
    }
}
