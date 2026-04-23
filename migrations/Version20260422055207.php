<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260422055207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('livres');

        if (!$table->hasColumn('slug')) {
            $this->addSql('ALTER TABLE livres ADD slug VARCHAR(191) NOT NULL');
        }

        if (!$table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE livres ADD created_at DATETIME NOT NULL');
        }

        if (!$table->hasColumn('updated_at')) {
            $this->addSql('ALTER TABLE livres ADD updated_at DATETIME NOT NULL');
        }

        // Ensure compatibility with old MySQL/MariaDB index length limits.
        $this->addSql('ALTER TABLE livres MODIFY slug VARCHAR(191) NOT NULL');

        // Backfill existing rows so unique index can be created safely.
        $this->addSql("UPDATE livres SET slug = CONCAT(LEFT(LOWER(REPLACE(REPLACE(titre, ' ', '-'), '\\'', '')), 180), '-', id) WHERE slug IS NULL OR slug = ''");

        if (!$table->hasIndex('UNIQ_927187A4989D9B62')) {
            $this->addSql('CREATE UNIQUE INDEX UNIQ_927187A4989D9B62 ON livres (slug)');
        }
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('livres');

        if ($table->hasIndex('UNIQ_927187A4989D9B62')) {
            $this->addSql('DROP INDEX UNIQ_927187A4989D9B62 ON livres');
        }

        if ($table->hasColumn('slug')) {
            $this->addSql('ALTER TABLE livres DROP slug');
        }

        if ($table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE livres DROP created_at');
        }

        if ($table->hasColumn('updated_at')) {
            $this->addSql('ALTER TABLE livres DROP updated_at');
        }
    }
}
