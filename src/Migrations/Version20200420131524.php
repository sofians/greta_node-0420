<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420131524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, libelle_cours VARCHAR(40) NOT NULL, nb_jours INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) DEFAULT \'Toulon\' NOT NULL');
        $this->addSql('ALTER TABLE seminaire ADD cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE seminaire ADD CONSTRAINT FK_B0F911907ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_B0F911907ECF78B0 ON seminaire (cours_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE seminaire DROP FOREIGN KEY FK_B0F911907ECF78B0');
        $this->addSql('DROP TABLE cours');
        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'\'\'Toulon\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_B0F911907ECF78B0 ON seminaire');
        $this->addSql('ALTER TABLE seminaire DROP cours_id');
    }
}
