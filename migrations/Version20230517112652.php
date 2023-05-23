<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230517112652 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `leave` DROP working_days');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE `leave` ADD working_days INT NOT NULL');
    }
}
