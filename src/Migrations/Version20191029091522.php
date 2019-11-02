<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029091522 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE has_field (id INT AUTO_INCREMENT NOT NULL, secteur_id INT DEFAULT NULL, field_label VARCHAR(255) NOT NULL, field_type VARCHAR(255) NOT NULL, true_value VARCHAR(255) NOT NULL, options LONGTEXT NOT NULL, INDEX IDX_A07C55E69F7E4405 (secteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE has_field ADD CONSTRAINT FK_A07C55E69F7E4405 FOREIGN KEY (secteur_id) REFERENCES secteur (id)');
        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE has_field');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }
}
