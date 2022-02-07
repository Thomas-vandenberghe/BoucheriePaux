<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220207093316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette ADD produit_id INT NOT NULL');
        $this->addSql('ALTER TABLE recette ADD CONSTRAINT FK_49BB6390F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_49BB6390F347EFB ON recette (produit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recette DROP FOREIGN KEY FK_49BB6390F347EFB');
        $this->addSql('DROP INDEX IDX_49BB6390F347EFB ON recette');
        $this->addSql('ALTER TABLE recette DROP produit_id');
    }
}
