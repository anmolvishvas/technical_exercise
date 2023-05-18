<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517110425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D034F7BA2');
        $this->addSql('DROP INDEX IDX_9BB080D034F7BA2 ON `leave`');
        $this->addSql('ALTER TABLE `leave` CHANGE collaborators_id collaborator_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D030098C8C FOREIGN KEY (collaborator_id) REFERENCES collaborator (id)');
        $this->addSql('CREATE INDEX IDX_9BB080D030098C8C ON `leave` (collaborator_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `leave` DROP FOREIGN KEY FK_9BB080D030098C8C');
        $this->addSql('DROP INDEX IDX_9BB080D030098C8C ON `leave`');
        $this->addSql('ALTER TABLE `leave` CHANGE collaborator_id collaborators_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `leave` ADD CONSTRAINT FK_9BB080D034F7BA2 FOREIGN KEY (collaborators_id) REFERENCES collaborator (id)');
        $this->addSql('CREATE INDEX IDX_9BB080D034F7BA2 ON `leave` (collaborators_id)');
    }
}
