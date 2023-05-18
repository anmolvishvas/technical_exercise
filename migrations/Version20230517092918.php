<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517092918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collaborator DROP FOREIGN KEY FK_606D487C1B2ADB5C');
        $this->addSql('DROP INDEX IDX_606D487C1B2ADB5C ON collaborator');
        $this->addSql('ALTER TABLE collaborator DROP leave_id');
        $this->addSql('ALTER TABLE `leave` ADD collaborators_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D034F7BA2 FOREIGN KEY (collaborators_id) REFERENCES collaborator (id)');
        $this->addSql('CREATE INDEX IDX_9BB080D034F7BA2 ON `leave` (collaborators_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE collaborator ADD leave_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE collaborator ADD CONSTRAINT FK_606D487C1B2ADB5C FOREIGN KEY (leave_id) REFERENCES `leave` (id)');
        $this->addSql('CREATE INDEX IDX_606D487C1B2ADB5C ON collaborator (leave_id)');
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D034F7BA2');
        $this->addSql('DROP INDEX IDX_9BB080D034F7BA2 ON `leave`');
        $this->addSql('ALTER TABLE `leave` DROP collaborators_id');
    }
}
