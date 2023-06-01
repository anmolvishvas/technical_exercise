<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230515132309 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('DROP TABLE Collaborator');
        $this->addSql('CREATE TABLE collaborator (id INT AUTO_INCREMENT NOT NULL, planning_id INT DEFAULT NULL, family_name VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, job_title VARCHAR(255) NOT NULL, INDEX IDX_606D487C3D865311 (planning_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487C3D865311 FOREIGN KEY (planning_id) REFERENCES planning (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487C3D865311');
        $this->addSql('DROP TABLE collaborator');
    }
}
