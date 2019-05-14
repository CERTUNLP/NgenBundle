<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190506203003 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB ROW_FORMAT = DYNAMIC');
        $this->addSql('INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (19, "es", "CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState", "name", "open", "Abierto")');
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (26, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'closed', 'Cerrado')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (27, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'closed_by_inactivity', 'Cerrado por inactividad')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (28, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'staging', 'En espera')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (29, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'undefined', 'Indefinido')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (30, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'unresolved', 'Sin resolver')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (31, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'removed', 'Eliminado')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (32, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentState', 'name', 'stand_by', 'En espera')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (33, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentImpact', 'name', 'high', 'Alta')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (34, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentImpact', 'name', 'low', 'Baja')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (35, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentImpact', 'name', 'medium', 'Media')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (36, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentImpact', 'name', 'undefined', 'Sin definir')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (37, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentUrgency', 'name', 'high', 'Alta')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (38, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentUrgency', 'name', 'low', 'Baja')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (39, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentUrgency', 'name', 'medium', 'Media')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (40, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentUrgency', 'name', 'undefined', 'Sin definir')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (41, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'high_high', 'Critica')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (42, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'high_low', 'Media')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (43, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'high_medium', 'Alta')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (44, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'low_high', 'Media')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (45, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'low_low', 'Muy baja')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (46, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'low_medium', 'Baja')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (47, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'medium_high', 'Alta')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (48, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'medium_low', 'Baja')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (49, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'medium_medium', 'Media')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (50, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentPriority', 'name', 'undefined_undefined', 'Sin definir')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (52, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentTlp', 'name', 'amber', 'AMBAR')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (53, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentTlp', 'name', 'green', 'VERDE')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (54, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentTlp', 'name', 'red', 'ROJO')");
        $this->addSql("INSERT INTO ngen.ext_translations (id, locale, object_class, field, foreign_key, content) VALUES (55, 'es', 'CertUnlp\\\NgenBundle\\\Entity\\\Incident\\\IncidentTlp', 'name', 'white', 'BLANCO')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ext_translations2');
        $this->addSql('ALTER TABLE incident ADD host_address VARCHAR(20) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
