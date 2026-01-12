<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260112202523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Equipe d\'animation pour un sejour';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE sejour_user (sejour_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(sejour_id, user_id))');
        $this->addSql('CREATE INDEX IDX_1521F10E84CF0CF ON sejour_user (sejour_id)');
        $this->addSql('CREATE INDEX IDX_1521F10EA76ED395 ON sejour_user (user_id)');
        $this->addSql('ALTER TABLE sejour_user ADD CONSTRAINT FK_1521F10E84CF0CF FOREIGN KEY (sejour_id) REFERENCES sejour (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sejour_user ADD CONSTRAINT FK_1521F10EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sejour_user DROP CONSTRAINT FK_1521F10E84CF0CF');
        $this->addSql('ALTER TABLE sejour_user DROP CONSTRAINT FK_1521F10EA76ED395');
        $this->addSql('DROP TABLE sejour_user');
    }
}
