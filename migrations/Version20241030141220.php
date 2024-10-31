<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241030141220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d64919eb6921');
        $this->addSql('DROP INDEX uniq_8d93d64919eb6921');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP client_id');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE "user" ALTER is_active DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_login ON "user" (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_login');
        $this->addSql('ALTER TABLE "user" ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" DROP roles');
        $this->addSql('ALTER TABLE "user" ALTER login TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE "user" ALTER prenom TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE "user" ALTER is_active SET NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d64919eb6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d64919eb6921 ON "user" (client_id)');
    }
}
