<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230518085835 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `leave` CHANGE reason reason ENUM(\'paid\', \'unpaid\', \'exceptional\', \'seniority\') NOT NULL COMMENT \'(DC2Type:EnumLeaveReasonType)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE `leave` CHANGE reason reason VARCHAR(255) NOT NULL');
    }
}
