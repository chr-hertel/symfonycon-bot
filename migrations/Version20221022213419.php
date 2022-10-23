<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022213419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Converting IDs to UUID';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, title, start, "end", speaker, track, description FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id BLOB NOT NULL --(DC2Type:uuid)
        , title VARCHAR(255) NOT NULL, start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , speaker VARCHAR(255) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO slot (id, title, start, "end", speaker, track, description) SELECT id, title, start, "end", speaker, track, description FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, title, start, "end", speaker, track, description FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , speaker VARCHAR(255) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO slot (id, title, start, "end", speaker, track, description) SELECT id, title, start, "end", speaker, track, description FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
    }
}
