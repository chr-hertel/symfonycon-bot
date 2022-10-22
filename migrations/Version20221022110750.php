<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022110750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adding Slot Description';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slot ADD COLUMN description CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, title, start, "end", speaker, track FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , speaker VARCHAR(255) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO slot (id, title, start, "end", speaker, track) SELECT id, title, start, "end", speaker, track FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
    }
}
