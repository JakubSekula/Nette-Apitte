<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210917110726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE author_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE book_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE location_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE magazine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE publisher_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE author (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE book (id INT NOT NULL, author INT DEFAULT NULL, publisher INT DEFAULT NULL, category INT DEFAULT NULL, name VARCHAR(255) NOT NULL, published VARCHAR(255) NOT NULL, isbn VARCHAR(255) NOT NULL, borrowed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CBE5A331BDAFD8C8 ON book (author)');
        $this->addSql('CREATE INDEX IDX_CBE5A3319CE8D546 ON book (publisher)');
        $this->addSql('CREATE INDEX IDX_CBE5A33164C19C1 ON book (category)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE location (id INT NOT NULL, library VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, pegi INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE magazine (id INT NOT NULL, publisher INT DEFAULT NULL, name VARCHAR(255) NOT NULL, borrowed BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_378C2FE49CE8D546 ON magazine (publisher)');
        $this->addSql('CREATE TABLE publisher (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, state INT NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, apikey VARCHAR(255) NOT NULL, last_logged_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331BDAFD8C8 FOREIGN KEY (author) REFERENCES author (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3319CE8D546 FOREIGN KEY (publisher) REFERENCES publisher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33164C19C1 FOREIGN KEY (category) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE magazine ADD CONSTRAINT FK_378C2FE49CE8D546 FOREIGN KEY (publisher) REFERENCES publisher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A331BDAFD8C8');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A33164C19C1');
        $this->addSql('ALTER TABLE book DROP CONSTRAINT FK_CBE5A3319CE8D546');
        $this->addSql('ALTER TABLE magazine DROP CONSTRAINT FK_378C2FE49CE8D546');
        $this->addSql('DROP SEQUENCE author_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE book_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE location_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE magazine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE publisher_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE location');
        $this->addSql('DROP TABLE magazine');
        $this->addSql('DROP TABLE publisher');
        $this->addSql('DROP TABLE "user"');
    }
}
