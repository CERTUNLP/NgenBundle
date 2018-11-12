<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181107171409 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11ADB5CDBB2');
        $this->addSql('DROP INDEX IDX_3D03A11ADB5CDBB2 ON incident');
        $this->addSql('ALTER TABLE incident CHANGE asigned_id assigned_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1501A05 FOREIGN KEY (assigned_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11AE1501A05 ON incident (assigned_id)');
        $this->addSql("INSERT INTO `incident_urgency` VALUES ('High','High','The damage caused by the Incident increases rapidly.\nWork that cannot be completed by staff is highly time sensitive.\nA minor Incident can be prevented from becoming a major Incident by acting immediately.\nSeveral users with VIP status are affected.'),('Low','Low','The damage caused by the Incident only marginally increases over time.\nWork that cannot be completed by staff is not time sensitive.'),('Medium','Medium','The damage caused by the Incident increases considerably over time.\nA single user with VIP status is affected')");
        $this->addSql("INSERT INTO `incident_impact` (`slug`, `name`, `description`) VALUES ('Low', 'Low', 'A minimal number of staff are affected and/or able to deliver an acceptable service but this requires extra effort.\nA minimal number of customers are affected and/or inconvenienced but not in a significant way.\nThe financial impact of the Incident is (for example) likely to be less than $1,000.\nThe damage to the reputation of the business is likely to be minimal.')");
        $this->addSql("INSERT INTO `incident_impact` (`slug`, `name`, `description`) VALUES ('Medium', 'Medium', 'A moderate number of staff are affected and/or not able to do their job properly.\nA moderate number of customers are affected and/or inconvenienced in some way.\nThe financial impact of the Incident is (for example) likely to exceed $1,000 but will not be more than $10,000.\nThe damage to the reputation of the business is likely to be moderate.')");
        $this->addSql("INSERT INTO `incident_impact` (`slug`, `name`, `description`) VALUES ('High', 'High', 'A large number of staff are affected and/or not able to do their job. A large number of customers are affected and/or acutely disadvantaged in some way. The financial impact of the Incident is (for example) likely to exceed $10,000. The damage to the reputation of the business is likely to be high. Someone has been injured.')");

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1501A05');
        $this->addSql('DROP INDEX IDX_3D03A11AE1501A05 ON incident');
        $this->addSql('ALTER TABLE incident CHANGE assigned_id asigned_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11ADB5CDBB2 FOREIGN KEY (asigned_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3D03A11ADB5CDBB2 ON incident (asigned_id)');
        $this->addSql('ALTER TABLE incident_tlp CHANGE description description VARCHAR(150) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
