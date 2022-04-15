<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413101529 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, ab_nom VARCHAR(255) DEFAULT NULL, ab_type VARCHAR(255) DEFAULT NULL, ab_prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorieabo (id INT AUTO_INCREMENT NOT NULL, abonnement_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_E6262FF4F1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorieabo ADD CONSTRAINT FK_E6262FF4F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorieabo DROP FOREIGN KEY FK_E6262FF4F1D74413');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE categorieabo');
    }
}
