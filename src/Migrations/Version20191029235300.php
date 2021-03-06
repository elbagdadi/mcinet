<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029235300 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE futur_investisseur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE has_field CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE selector_id selector_id VARCHAR(255) DEFAULT NULL, CHANGE selector_classes selector_classes VARCHAR(255) DEFAULT NULL, CHANGE selector_placeholder selector_placeholder VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE futur_investisseur');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE has_field CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE selector_id selector_id VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE selector_classes selector_classes VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE selector_placeholder selector_placeholder VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }
}
