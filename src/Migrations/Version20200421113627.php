<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421113627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) DEFAULT \'Toulon\' NOT NULL');
        $this->addSql('ALTER TABLE seminaire CHANGE cours_id cours_id INT DEFAULT NULL, CHANGE libellecours dateDebutSeminaire DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE employe CHANGE projet_id projet_id INT DEFAULT NULL, CHANGE ville ville VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT \'\'\'Toulon\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE seminaire CHANGE cours_id cours_id INT DEFAULT NULL, CHANGE datedebutseminaire libelleCours DATE NOT NULL');
    }
}
