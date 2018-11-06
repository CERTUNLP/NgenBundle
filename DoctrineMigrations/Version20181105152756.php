<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181105152756 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

//        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AB8037C6C FOREIGN KEY (tlp_state) REFERENCES tlp (name)');
//        $this->addSql('CREATE INDEX IDX_3D03A11AB8037C6C ON incident (tlp_state)');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT AUTO_INCREMENT NOT NULL, CHANGE description description VARCHAR(45) DEFAULT NULL');
        $this->addSql("INSERT INTO tlp VALUES (1,'red','#ff0033','Sources may use TLP:RED when information cannot be effectively acted upon by additional parties, and could lead to impacts on a party\'s privacy, reputation, or operations if misused.',1,'Recipients may not share TLP:RED information with any parties outside of the specific exchange, meeting, or conversation in which it was originally disclosed. In the context of a meeting, for example, TLP:RED information is limited to those present at the meeting. In most circumstances, TLP:RED should be exchanged verbally or in person.','TLP:RED','Not for disclosure, restricted to participants only.'),(2,'amber','#ffc000','Sources may use TLP:AMBER when information requires support to be effectively acted upon, yet carries risks to privacy, reputation, or operations if shared outside of the organizations involved. 	',0,'Recipients may only share TLP:AMBER information with members of their own organization, and with clients or customers who need to know the information to protect themselves or prevent further harm. Sources are at liberty to specify additional intended limits of the sharing: these must be adhered to.\n','TLP:AMBER','Limited disclosure, restricted to participants organizations.'),(3,'green','#33ff00','Sources may use TLP:GREEN when information is useful for the awareness of all participating organizations as well as with peers within the broader community or sector.	',0,'Recipients may share TLP:GREEN information with peers and partner organizations within their sector or community, but not via publicly accessible channels. Information in this category can be circulated widely within a particular community. TLP:GREEN information may not be released outside of the community.\n','TLP:GREEN','Limited disclosure, restricted to the community.'),(4,'white','#FFFFFF','Sources may use TLP:WHITE when information carries minimal or no foreseeable risk of misuse, in accordance with applicable rules and procedures for public release.	',0,'Subject to standard copyright rules, TLP:WHITE information may be distributed without restriction.\n','TLP:WHITE','Disclosure is not limited.')");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AB8037C6C');
        $this->addSql('DROP INDEX IDX_3D03A11AB8037C6C ON incident');
        $this->addSql('ALTER TABLE tlp CHANGE idtlp idtlp INT NOT NULL, CHANGE description description VARCHAR(150) DEFAULT NULL COLLATE latin1_swedish_ci');
    }
}
