<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602173923 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE books_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE file_locations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE languages_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE authors_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE books (id INT NOT NULL, author INT DEFAULT NULL, language INT DEFAULT NULL, location INT DEFAULT NULL, title VARCHAR(255) NOT NULL, uploaded_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4A1B2A92BDAFD8C8 ON books (author)');
        $this->addSql('CREATE INDEX IDX_4A1B2A92D4DB71B5 ON books (language)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4A1B2A925E9E89CB ON books (location)');
        $this->addSql('CREATE TABLE file_locations (id INT NOT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE languages (id INT NOT NULL, code VARCHAR(25) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A0D1537977153098 ON languages (code)');
        $this->addSql('CREATE TABLE authors (id INT NOT NULL, name VARCHAR(255) NOT NULL, unified_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E0C2A515E237E06 ON authors (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E0C2A51877E36BF ON authors (unified_name)');
        $this->addSql('CREATE INDEX author_idx ON authors (unified_name)');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92BDAFD8C8 FOREIGN KEY (author) REFERENCES authors (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A92D4DB71B5 FOREIGN KEY (language) REFERENCES languages (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE books ADD CONSTRAINT FK_4A1B2A925E9E89CB FOREIGN KEY (location) REFERENCES file_locations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A925E9E89CB');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A92D4DB71B5');
        $this->addSql('ALTER TABLE books DROP CONSTRAINT FK_4A1B2A92BDAFD8C8');
        $this->addSql('DROP SEQUENCE books_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE file_locations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE languages_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE authors_id_seq CASCADE');
        $this->addSql('DROP TABLE books');
        $this->addSql('DROP TABLE file_locations');
        $this->addSql('DROP TABLE languages');
        $this->addSql('DROP TABLE authors');
    }
}
