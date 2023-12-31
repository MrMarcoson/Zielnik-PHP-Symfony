<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230827010205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herb ADD author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE herb ADD CONSTRAINT FK_2F7F123BF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2F7F123BF675F31B ON herb (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE herb DROP FOREIGN KEY FK_2F7F123BF675F31B');
        $this->addSql('DROP INDEX IDX_2F7F123BF675F31B ON herb');
        $this->addSql('ALTER TABLE herb DROP author_id');
    }
}
