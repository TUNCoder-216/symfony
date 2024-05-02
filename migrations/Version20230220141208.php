<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220141208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile ADD nom_sup VARCHAR(255) NOT NULL, ADD adresse_sup VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user DROP image_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP nom_sup, DROP adresse_sup');
        $this->addSql('ALTER TABLE user ADD image_user VARCHAR(255) NOT NULL');
    }
}
