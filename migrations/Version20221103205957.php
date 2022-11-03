<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221103205957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, talk_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , attendee INTEGER NOT NULL, CONSTRAINT FK_6DE30D916F0601D5 FOREIGN KEY (talk_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6DE30D916F0601D5 ON attendance (talk_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6DE30D916F0601D51150D567 ON attendance (talk_id, attendee)');
        $this->addSql('CREATE TABLE attendee_rating (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, talk_id BLOB DEFAULT NULL --(DC2Type:uuid)
        , attendee INTEGER NOT NULL, rating INTEGER NOT NULL, CONSTRAINT FK_FDEEC1676F0601D5 FOREIGN KEY (talk_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FDEEC1676F0601D5 ON attendee_rating (talk_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FDEEC1676F0601D51150D567 ON attendee_rating (talk_id, attendee)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE attendee_rating');
    }
}
