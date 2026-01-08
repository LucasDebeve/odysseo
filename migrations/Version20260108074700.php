<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260108074700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Enrichissement des tables utilisateurs et diplomes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE diplome (id SERIAL NOT NULL, nom VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, is_equivalent_bafa BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_diplome (user_id INT NOT NULL, diplome_id INT NOT NULL, PRIMARY KEY(user_id, diplome_id))');
        $this->addSql('CREATE INDEX IDX_B3415344A76ED395 ON user_diplome (user_id)');
        $this->addSql('CREATE INDEX IDX_B341534426F859E2 ON user_diplome (diplome_id)');
        $this->addSql('ALTER TABLE user_diplome ADD CONSTRAINT FK_B3415344A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_diplome ADD CONSTRAINT FK_B341534426F859E2 FOREIGN KEY (diplome_id) REFERENCES diplome (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD avatar_path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD date_nais DATE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN "user".date_nais IS \'(DC2Type:date_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_diplome DROP CONSTRAINT FK_B3415344A76ED395');
        $this->addSql('ALTER TABLE user_diplome DROP CONSTRAINT FK_B341534426F859E2');
        $this->addSql('DROP TABLE diplome');
        $this->addSql('DROP TABLE user_diplome');
        $this->addSql('ALTER TABLE "user" DROP description');
        $this->addSql('ALTER TABLE "user" DROP avatar_path');
        $this->addSql('ALTER TABLE "user" DROP date_nais');
    }
}
