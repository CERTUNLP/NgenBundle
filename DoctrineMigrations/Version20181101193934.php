<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181101193934 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `tlp` (    `idtlp` int(11) NOT NULL,  `name` varchar(45) DEFAULT NULL,  `rgb` varchar(45) DEFAULT NULL,  `when` varchar(500) DEFAULT NULL,  `encrypt` tinyint(1) DEFAULT NULL,  `why` varchar(500) DEFAULT NULL,  `information` varchar(10) DEFAULT NULL,  `description` varchar(150) DEFAULT NULL,  PRIMARY KEY (`idtlp`)) ENGINE=InnoDB DEFAULT CHARSET=latin1");
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE incident ADD tlp_state VARCHAR(45) DEFAULT NULL');
#       $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES tlp (name)');
        $this->addSql('CREATE INDEX IDX_3D03A11AB8037C6C ON incident (tlp_state)');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT AUTO_INCREMENT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('DROP TABLE tlp');
 #       $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('DROP INDEX IDX_3D03A11AB8037C6C ON incident');
        $this->addSql('ALTER TABLE incident DROP tlp_state');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT NOT NULL');
    }
}
