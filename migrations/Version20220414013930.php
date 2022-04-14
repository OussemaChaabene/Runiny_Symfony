<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414013930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, poids INT NOT NULL, sodium INT NOT NULL, cholesterol INT NOT NULL, carbohydrate INT NOT NULL, protein INT NOT NULL, calories INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP TABLE regime');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495544600370 FOREIGN KEY (id_even) REFERENCES evenement (id_even)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A0123F6C FOREIGN KEY (id_salle) REFERENCES salle (id_salle)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, user INT NOT NULL, plats INT NOT NULL, titre VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, objectif VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX fk_regime_user (user), INDEX IDX_AA864A7C854A620A (plats), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT fk_regime_user FOREIGN KEY (user) REFERENCES user (id_user) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE regime ADD CONSTRAINT fk_regime_plat FOREIGN KEY (plats) REFERENCES plat (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('DROP TABLE plat');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495544600370');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A0123F6C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556B3CA4B');
    }
}
