<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260422062000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename auteur.slug unique index to Doctrine expected name';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('auteur');

        if ($table->hasIndex('UNIQ_60BB6FE6989D9B62') && !$table->hasIndex('UNIQ_55AB140989D9B62')) {
            $this->addSql('ALTER TABLE auteur RENAME INDEX UNIQ_60BB6FE6989D9B62 TO UNIQ_55AB140989D9B62');
        }
    }

    public function down(Schema $schema): void
    {
        $table = $schema->getTable('auteur');

        if ($table->hasIndex('UNIQ_55AB140989D9B62') && !$table->hasIndex('UNIQ_60BB6FE6989D9B62')) {
            $this->addSql('ALTER TABLE auteur RENAME INDEX UNIQ_55AB140989D9B62 TO UNIQ_60BB6FE6989D9B62');
        }
    }
}
