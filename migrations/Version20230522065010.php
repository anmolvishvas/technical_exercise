<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230522065010 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `leave` ADD planning_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D03D865311 FOREIGN KEY (planning_id) REFERENCES planning (id)');
        $this->addSql('CREATE INDEX IDX_9BB080D03D865311 ON `leave` (planning_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D03D865311');
        $this->addSql('DROP INDEX IDX_9BB080D03D865311 ON `leave`');
        $this->addSql('ALTER TABLE `leave` DROP planning_id');
    }
}
