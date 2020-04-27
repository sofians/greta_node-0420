<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200420133644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE CoursTheme (cours_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_97BA84287ECF78B0 (cours_id), INDEX IDX_97BA842859027487 (theme_id), PRIMARY KEY(cours_id, theme_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE CoursTheme ADD CONSTRAINT FK_97BA84287ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE CoursTheme ADD CONSTRAINT FK_97BA842859027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) DEFAULT \'Toulon\' NOT NULL');
        $this->addSql('ALTER TABLE seminaire CHANGE cours_id cours_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE CoursTheme DROP FOREIGN KEY FK_97BA842859027487');
        $this->addSql('DROP TABLE CoursTheme');
        $this->addSql('DROP TABLE theme');
        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'\'\'Toulon\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE seminaire CHANGE cours_id cours_id INT DEFAULT NULL');
    }
}
