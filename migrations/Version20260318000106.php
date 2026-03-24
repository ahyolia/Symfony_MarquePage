<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260318000106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres ADD resume VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE livres ADD CONSTRAINT FK_927187A460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id)');
        $this->addSql('ALTER TABLE marque_page_mots_cle ADD CONSTRAINT FK_7F2E7E3AD59CC0F1 FOREIGN KEY (marque_page_id) REFERENCES marque_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_page_mots_cle ADD CONSTRAINT FK_7F2E7E3ACD7C5471 FOREIGN KEY (mots_cle_id) REFERENCES mots_cle (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres DROP FOREIGN KEY FK_927187A460BB6FE6');
        $this->addSql('ALTER TABLE livres DROP resume');
        $this->addSql('ALTER TABLE marque_page_mots_cle DROP FOREIGN KEY FK_7F2E7E3AD59CC0F1');
        $this->addSql('ALTER TABLE marque_page_mots_cle DROP FOREIGN KEY FK_7F2E7E3ACD7C5471');
    }
}
