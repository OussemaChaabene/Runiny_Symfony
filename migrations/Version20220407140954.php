<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220407140954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC38B217A7');
        $this->addSql('DROP INDEX FK_67F068BC38B217A7 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP publication_id, DROP user_id, CHANGE date cdate DATETIME NOT NULL');
        $this->addSql('ALTER TABLE publication ADD cdate DATETIME NOT NULL, DROP active, CHANGE image image LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD publication_id INT NOT NULL, ADD user_id INT DEFAULT NULL, CHANGE cdate date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC38B217A7 FOREIGN KEY (publication_id) REFERENCES publication (id)');
        $this->addSql('CREATE INDEX FK_67F068BC38B217A7 ON commentaire (publication_id)');
        $this->addSql('ALTER TABLE publication ADD active TINYINT(1) NOT NULL, DROP cdate, CHANGE image image VARBINARY(255) DEFAULT NULL');
    }
}
