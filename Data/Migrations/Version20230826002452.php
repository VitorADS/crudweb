<?php

declare(strict_types=1);

namespace Data\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826002452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crudweb.annotation (id SERIAL NOT NULL, user_id INT NOT NULL, header VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, text TEXT NOT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updatedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deletedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F690BA4EA76ED395 ON crudweb.annotation (user_id)');
        $this->addSql('CREATE TABLE crudweb."user" (id SERIAL NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updatedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deletedAt TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX email ON crudweb."user" (email)');
        $this->addSql('ALTER TABLE crudweb.annotation ADD CONSTRAINT FK_F690BA4EA76ED395 FOREIGN KEY (user_id) REFERENCES crudweb."user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crudweb.annotation DROP CONSTRAINT FK_F690BA4EA76ED395');
        $this->addSql('DROP TABLE crudweb.annotation');
        $this->addSql('DROP TABLE crudweb."user"');
    }
}
