<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260316005937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE marque_page_mots_cle (marque_page_id INT NOT NULL, mots_cle_id INT NOT NULL, INDEX IDX_7F2E7E3AD59CC0F1 (marque_page_id), INDEX IDX_7F2E7E3ACD7C5471 (mots_cle_id), PRIMARY KEY (marque_page_id, mots_cle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE marque_page_mots_cle ADD CONSTRAINT FK_7F2E7E3AD59CC0F1 FOREIGN KEY (marque_page_id) REFERENCES marque_page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_page_mots_cle ADD CONSTRAINT FK_7F2E7E3ACD7C5471 FOREIGN KEY (mots_cle_id) REFERENCES mots_cle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque_page ADD mots_cles VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marque_page_mots_cle DROP FOREIGN KEY FK_7F2E7E3AD59CC0F1');
        $this->addSql('ALTER TABLE marque_page_mots_cle DROP FOREIGN KEY FK_7F2E7E3ACD7C5471');
        $this->addSql('DROP TABLE marque_page_mots_cle');
        $this->addSql('ALTER TABLE marque_page DROP mots_cles');
    }
}
