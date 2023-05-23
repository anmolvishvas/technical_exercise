<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230519062048 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE collaborator ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_606D487CA76ED395 ON collaborator (user_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487CA76ED395');
        $this->addSql('DROP INDEX UNIQ_606D487CA76ED395 ON collaborator');
        $this->addSql('ALTER TABLE collaborator DROP user_id');
    }
}
