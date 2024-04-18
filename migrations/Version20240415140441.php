<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415140441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bibliotheque CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE gestion_cours CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE premium CHANGE id_transaction id_transaction INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question CHANGE questionId questionId INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE quizId quizId INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE rate CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE solution CHANGE idsolution idsolution INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE studentgroup CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE task_id task_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE évenement CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE évenement CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE bibliotheque CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE categorie CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE gestion_cours CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE premium CHANGE id_transaction id_transaction INT NOT NULL');
        $this->addSql('ALTER TABLE question CHANGE questionId questionId INT NOT NULL');
        $this->addSql('ALTER TABLE quiz CHANGE quizId quizId INT NOT NULL');
        $this->addSql('ALTER TABLE rate CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE solution CHANGE idsolution idsolution INT NOT NULL');
        $this->addSql('ALTER TABLE studentgroup CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE tasks CHANGE task_id task_id INT NOT NULL');
    }
}
