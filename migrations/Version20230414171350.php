<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414171350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job ADD recruiter_id INT DEFAULT NULL, DROP author');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8156BE243 FOREIGN KEY (recruiter_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_FBD8E0F8156BE243 ON job (recruiter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8156BE243');
        $this->addSql('DROP INDEX IDX_FBD8E0F8156BE243 ON job');
        $this->addSql('ALTER TABLE job ADD author VARCHAR(255) NOT NULL, DROP recruiter_id');
    }
}
