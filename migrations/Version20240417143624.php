<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417143624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, specialite VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gestion_cours ADD fk_numero_id INT NOT NULL');
        $this->addSql('ALTER TABLE gestion_cours ADD CONSTRAINT FK_B0D5E37F3C4EFDE8 FOREIGN KEY (fk_numero_id) REFERENCES bibliotheque (id)');
        $this->addSql('CREATE INDEX IDX_B0D5E37F3C4EFDE8 ON gestion_cours (fk_numero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gestion_cours DROP FOREIGN KEY FK_B0D5E37F3C4EFDE8');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP INDEX IDX_B0D5E37F3C4EFDE8 ON gestion_cours');
        $this->addSql('ALTER TABLE gestion_cours DROP fk_numero_id');
    }
}
