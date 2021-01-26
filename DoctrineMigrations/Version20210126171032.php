<?php

declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210126171032 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE incident set unattended_state="discarded_by_innactivity" where unattended_state is null');
        $this->addSql('UPDATE incident set unsolved_state="closed_by_inactivity" where unsolved_state is null');
        $this->addSql('UPDATE incident set response_dead_line=STR_TO_DATE("2020-12-01", "%Y-%m-%d") where response_dead_line is null');
        $this->addSql('UPDATE incident set solve_dead_line=STR_TO_DATE("2020-12-01", "%Y-%m-%d") where solve_dead_line is null');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
