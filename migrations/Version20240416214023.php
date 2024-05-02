<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416214023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE classroom (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solution (id INT AUTO_INCREMENT NOT NULL, contenusolution VARCHAR(255) NOT NULL, nomadmin VARCHAR(255) NOT NULL, idreclamation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, idclass_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, moyenne INT NOT NULL, INDEX IDX_B723AF3340D5431D (idclass_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, type INT NOT NULL, connected INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF3340D5431D FOREIGN KEY (idclass_id) REFERENCES classroom (id)');
        $this->addSql('ALTER TABLE reclamation DROP iduser, CHANGE contenu contenu VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE student DROP FOREIGN KEY FK_B723AF3340D5431D');
        $this->addSql('DROP TABLE classroom');
        $this->addSql('DROP TABLE solution');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE reclamation ADD iduser INT NOT NULL, CHANGE contenu contenu VARCHAR(500) NOT NULL, CHANGE telephone telephone INT NOT NULL');
    }
}
