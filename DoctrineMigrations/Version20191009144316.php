<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20191009144316 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'CREATE TABLE `rt_predicates` ( `description` INT NOT NULL,`expanded` VARCHAR(45) NOT NULL,`value` VARCHAR(45) NOT NULL, PRIMARY KEY (`value`), `version` INT NOT NULL);'
        );
        $this->addSql(
            'CREATE TABLE `rt_values` (`description` INT NOT NULL, `expanded` VARCHAR(45) NOT NULL, `value` VARCHAR(45) NOT NULL, `predicate` VARCHAR(45) NOT NULL,`updated_at` TIMESTAMP NOT NULL DEFAULT NOW() ON UPDATE NOW(), PRIMARY KEY (`value`), `version` INT NOT NULL);'
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

    }
}
