<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260112204631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enfant_sejour (id SERIAL NOT NULL, sejour_id INT NOT NULL, enfant_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_159E7E6584CF0CF ON enfant_sejour (sejour_id)');
        $this->addSql('CREATE INDEX IDX_159E7E65450D2529 ON enfant_sejour (enfant_id)');
        $this->addSql('ALTER TABLE enfant_sejour ADD CONSTRAINT FK_159E7E6584CF0CF FOREIGN KEY (sejour_id) REFERENCES sejour (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE enfant_sejour ADD CONSTRAINT FK_159E7E65450D2529 FOREIGN KEY (enfant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE enfant_sejour DROP CONSTRAINT FK_159E7E6584CF0CF');
        $this->addSql('ALTER TABLE enfant_sejour DROP CONSTRAINT FK_159E7E65450D2529');
        $this->addSql('DROP TABLE enfant_sejour');
    }
}
