<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260109154542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE organisme (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, photo_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sejour (id SERIAL NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN sejour.date_debut IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN sejour.date_fin IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE organisme');
        $this->addSql('DROP TABLE sejour');
    }
}
