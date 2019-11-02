<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029161926 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE has_field ADD selector_id INT DEFAULT NULL, ADD selector_classes VARCHAR(255) DEFAULT NULL, ADD selector_placeholder VARCHAR(255) DEFAULT NULL, CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE has_field DROP selector_id, DROP selector_classes, DROP selector_placeholder, CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metier CHANGE secteur_id secteur_id INT DEFAULT NULL, CHANGE ecosystem_id ecosystem_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }
}
