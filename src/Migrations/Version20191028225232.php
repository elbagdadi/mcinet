<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028225232 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE metier ADD ecosystem_id INT DEFAULT NULL, CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metier ADD CONSTRAINT FK_51A00D8C146249B8 FOREIGN KEY (ecosystem_id) REFERENCES ecosystem (id)');
        $this->addSql('CREATE INDEX IDX_51A00D8C146249B8 ON metier (ecosystem_id)');
        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ecosystem CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE metier DROP FOREIGN KEY FK_51A00D8C146249B8');
        $this->addSql('DROP INDEX IDX_51A00D8C146249B8 ON metier');
        $this->addSql('ALTER TABLE metier DROP ecosystem_id, CHANGE secteur_id secteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE secteur CHANGE parent_id parent_id INT DEFAULT NULL');
    }
}
