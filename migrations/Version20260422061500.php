<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260422061500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add slug, created_at and updated_at to auteur and backfill slug values';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('auteur');

        if (!$table->hasColumn('slug')) {
            $this->addSql('ALTER TABLE auteur ADD slug VARCHAR(191) NOT NULL');
        }

        if (!$table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE auteur ADD created_at DATETIME NOT NULL');
        }

        if (!$table->hasColumn('updated_at')) {
            $this->addSql('ALTER TABLE auteur ADD updated_at DATETIME NOT NULL');
        }

        $this->addSql('ALTER TABLE auteur MODIFY slug VARCHAR(191) NOT NULL');

        // Backfill existing authors to avoid unique index conflicts.
        $this->addSql("UPDATE auteur SET slug = CONCAT(LEFT(LOWER(REPLACE(REPLACE(CONCAT(prenom, '-', nom), ' ', '-'), '\\'', '')), 180)) WHERE slug IS NULL OR slug = ''");

        if (!$table->hasIndex('UNIQ_60BB6FE6989D9B62')) {
            $this->addSql('CREATE UNIQUE INDEX UNIQ_60BB6FE6989D9B62 ON auteur (slug)');
        }
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('auteur');

        if ($table->hasIndex('UNIQ_60BB6FE6989D9B62')) {
            $this->addSql('DROP INDEX UNIQ_60BB6FE6989D9B62 ON auteur');
        }

        if ($table->hasColumn('slug')) {
            $this->addSql('ALTER TABLE auteur DROP slug');
        }

        if ($table->hasColumn('created_at')) {
            $this->addSql('ALTER TABLE auteur DROP created_at');
        }

        if ($table->hasColumn('updated_at')) {
            $this->addSql('ALTER TABLE auteur DROP updated_at');
        }
    }
}
