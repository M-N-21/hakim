<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208200526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gerant ADD proprietaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE gerant ADD CONSTRAINT FK_D1D45C7076C50E4A FOREIGN KEY (proprietaire_id) REFERENCES proprietaire (id)');
        $this->addSql('CREATE INDEX IDX_D1D45C7076C50E4A ON gerant (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gerant DROP FOREIGN KEY FK_D1D45C7076C50E4A');
        $this->addSql('DROP INDEX IDX_D1D45C7076C50E4A ON gerant');
        $this->addSql('ALTER TABLE gerant DROP proprietaire_id');
    }
}
