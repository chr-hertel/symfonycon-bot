<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029202016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE event (id BLOB NOT NULL --(DC2Type:uuid)
        , slot_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , title VARCHAR(255) NOT NULL, start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , dtype VARCHAR(255) NOT NULL, speaker VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_3BAE0AA759E5119C FOREIGN KEY (slot_id) REFERENCES slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA759E5119C ON event (slot_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, start, "end" FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id BLOB NOT NULL --(DC2Type:uuid)
        , previous_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , next_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(id), CONSTRAINT FK_AC0E20672DE62210 FOREIGN KEY (previous_id) REFERENCES slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AC0E2067AA23F6C8 FOREIGN KEY (next_id) REFERENCES slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO slot (id, start, "end") SELECT id, start, "end" FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC0E20672DE62210 ON slot (previous_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC0E2067AA23F6C8 ON slot (next_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE event');
        $this->addSql('CREATE TEMPORARY TABLE __temp__slot AS SELECT id, start, "end" FROM slot');
        $this->addSql('DROP TABLE slot');
        $this->addSql('CREATE TABLE slot (id BLOB NOT NULL --(DC2Type:uuid)
        , start DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , "end" DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , title VARCHAR(255) NOT NULL, speaker VARCHAR(255) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO slot (id, start, "end") SELECT id, start, "end" FROM __temp__slot');
        $this->addSql('DROP TABLE __temp__slot');
    }
}
