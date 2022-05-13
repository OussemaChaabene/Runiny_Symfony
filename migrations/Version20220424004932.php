<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424004932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (ab_id INT AUTO_INCREMENT NOT NULL, id_salle INT DEFAULT NULL, ab_nom VARCHAR(255) NOT NULL, ab_type VARCHAR(255) NOT NULL, ab_prix INT NOT NULL, INDEX id_salle (id_salle), PRIMARY KEY(ab_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carac_sport (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, taille INT NOT NULL, poids INT NOT NULL, prot_needs INT DEFAULT NULL, calorie_need INT DEFAULT NULL, age INT DEFAULT NULL, genre VARCHAR(255) NOT NULL, INDEX fk_carac_user (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catégorieabo (id_categ INT AUTO_INCREMENT NOT NULL, ab_id INT DEFAULT NULL, id_user INT DEFAULT NULL, INDEX id_user (id_user), INDEX ab_id (ab_id), PRIMARY KEY(id_categ)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id_emp INT AUTO_INCREMENT NOT NULL, date_nais VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, profession VARCHAR(255) NOT NULL, PRIMARY KEY(id_emp)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id_even INT AUTO_INCREMENT NOT NULL, id_salle INT DEFAULT NULL, descri VARCHAR(255) NOT NULL, Date VARCHAR(255) NOT NULL, nom_even VARCHAR(255) NOT NULL, INDEX id_salle (id_salle), PRIMARY KEY(id_even)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (idEven INT AUTO_INCREMENT NOT NULL, dateEven DATE NOT NULL, descri VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, PRIMARY KEY(idEven)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id_parti INT AUTO_INCREMENT NOT NULL, idEvent INT NOT NULL, id_user INT NOT NULL, PRIMARY KEY(id_parti)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payement (id_pay INT AUTO_INCREMENT NOT NULL, ab_id INT DEFAULT NULL, id_user INT DEFAULT NULL, montant INT NOT NULL, date_pay VARCHAR(255) NOT NULL, INDEX ab_id (ab_id), INDEX id_user (id_user), PRIMARY KEY(id_pay)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_client (id_p INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_seance INT DEFAULT NULL, INDEX id_user (id_user), INDEX id_seance (id_seance), PRIMARY KEY(id_p)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE planning_coach (id_p INT AUTO_INCREMENT NOT NULL, id_user INT DEFAULT NULL, id_seance INT DEFAULT NULL, INDEX id_user (id_user), INDEX id_seance (id_seance), PRIMARY KEY(id_p)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plat (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, poids INT NOT NULL, sodium INT NOT NULL, cholesterol INT NOT NULL, carbohydrate INT NOT NULL, protein INT NOT NULL, calories INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, niveau INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regime_plat (regime_id INT NOT NULL, plat_id INT NOT NULL, INDEX IDX_4C654DA35E7D534 (regime_id), INDEX IDX_4C654DAD73DB560 (plat_id), PRIMARY KEY(regime_id, plat_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id_reser INT AUTO_INCREMENT NOT NULL, id_even INT DEFAULT NULL, id_salle INT DEFAULT NULL, id_user INT DEFAULT NULL, date_res VARCHAR(255) NOT NULL, INDEX id_even (id_even), INDEX id_user (id_user), INDEX id_salle (id_salle), PRIMARY KEY(id_reser)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id_salle INT AUTO_INCREMENT NOT NULL, adress_salle VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, rating INT NOT NULL, PRIMARY KEY(id_salle)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id_seance INT AUTO_INCREMENT NOT NULL, date INT NOT NULL, heur INT NOT NULL, type_seance INT NOT NULL, PRIMARY KEY(id_seance)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id_user INT AUTO_INCREMENT NOT NULL, Nom VARCHAR(255) NOT NULL, Prenom VARCHAR(255) NOT NULL, Adress VARCHAR(255) NOT NULL, Date_nais VARCHAR(255) NOT NULL, Role VARCHAR(255) NOT NULL, Login VARCHAR(255) NOT NULL, Password VARCHAR(255) NOT NULL, UNIQUE INDEX Login (Login), PRIMARY KEY(id_user)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA0123F6C FOREIGN KEY (id_salle) REFERENCES salle (id_salle)');
        $this->addSql('ALTER TABLE carac_sport ADD CONSTRAINT FK_C5A191788D93D649 FOREIGN KEY (user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE catégorieabo ADD CONSTRAINT FK_20FD8F836A5F8A4A FOREIGN KEY (ab_id) REFERENCES abonnement (ab_id)');
        $this->addSql('ALTER TABLE catégorieabo ADD CONSTRAINT FK_20FD8F836B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EA0123F6C FOREIGN KEY (id_salle) REFERENCES salle (id_salle)');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A78856A5F8A4A FOREIGN KEY (ab_id) REFERENCES abonnement (ab_id)');
        $this->addSql('ALTER TABLE payement ADD CONSTRAINT FK_B20A78856B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE planning_client ADD CONSTRAINT FK_A765263A6B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE planning_client ADD CONSTRAINT FK_A765263AF94A48E3 FOREIGN KEY (id_seance) REFERENCES seance (id_seance)');
        $this->addSql('ALTER TABLE planning_coach ADD CONSTRAINT FK_AEF5D7536B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE planning_coach ADD CONSTRAINT FK_AEF5D753F94A48E3 FOREIGN KEY (id_seance) REFERENCES seance (id_seance)');
        $this->addSql('ALTER TABLE regime_plat ADD CONSTRAINT FK_4C654DA35E7D534 FOREIGN KEY (regime_id) REFERENCES regime (id)');
        $this->addSql('ALTER TABLE regime_plat ADD CONSTRAINT FK_4C654DAD73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495544600370 FOREIGN KEY (id_even) REFERENCES evenement (id_even)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A0123F6C FOREIGN KEY (id_salle) REFERENCES salle (id_salle)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849556B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE catégorieabo DROP FOREIGN KEY FK_20FD8F836A5F8A4A');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A78856A5F8A4A');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495544600370');
        $this->addSql('ALTER TABLE regime_plat DROP FOREIGN KEY FK_4C654DAD73DB560');
        $this->addSql('ALTER TABLE regime_plat DROP FOREIGN KEY FK_4C654DA35E7D534');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA0123F6C');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EA0123F6C');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A0123F6C');
        $this->addSql('ALTER TABLE planning_client DROP FOREIGN KEY FK_A765263AF94A48E3');
        $this->addSql('ALTER TABLE planning_coach DROP FOREIGN KEY FK_AEF5D753F94A48E3');
        $this->addSql('ALTER TABLE carac_sport DROP FOREIGN KEY FK_C5A191788D93D649');
        $this->addSql('ALTER TABLE catégorieabo DROP FOREIGN KEY FK_20FD8F836B3CA4B');
        $this->addSql('ALTER TABLE payement DROP FOREIGN KEY FK_B20A78856B3CA4B');
        $this->addSql('ALTER TABLE planning_client DROP FOREIGN KEY FK_A765263A6B3CA4B');
        $this->addSql('ALTER TABLE planning_coach DROP FOREIGN KEY FK_AEF5D7536B3CA4B');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849556B3CA4B');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE carac_sport');
        $this->addSql('DROP TABLE catégorieabo');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE payement');
        $this->addSql('DROP TABLE planning_client');
        $this->addSql('DROP TABLE planning_coach');
        $this->addSql('DROP TABLE plat');
        $this->addSql('DROP TABLE regime');
        $this->addSql('DROP TABLE regime_plat');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE user');
    }
}
