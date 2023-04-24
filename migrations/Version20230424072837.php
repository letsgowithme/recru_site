<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424072837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64944F779A2');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A167B3B43D');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP INDEX UNIQ_8D93D64944F779A2 ON user');
        $this->addSql('ALTER TABLE user DROP consultant_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, UNIQUE INDEX UNIQ_441282A167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A167B3B43D FOREIGN KEY (users_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE user ADD consultant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64944F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64944F779A2 ON user (consultant_id)');
    }
}
