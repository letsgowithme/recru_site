<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416160827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidat (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_6AB5B471A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE candidat_job (candidat_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_93B2BA8C8D0EB82 (candidat_id), INDEX IDX_93B2BA8CBE04EA9 (job_id), PRIMARY KEY(candidat_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, location LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, users_id INT NOT NULL, UNIQUE INDEX UNIQ_441282A167B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, location LONGTEXT NOT NULL, description LONGTEXT NOT NULL, salary INT NOT NULL, schedule LONGTEXT NOT NULL, is_approved TINYINT(1) NOT NULL, is_published TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FBD8E0F8F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job_user (job_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A5FA008BE04EA9 (job_id), INDEX IDX_A5FA008A76ED395 (user_id), PRIMARY KEY(job_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recruiter (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, company_id INT NOT NULL, UNIQUE INDEX UNIQ_DE8633D8A76ED395 (user_id), INDEX IDX_DE8633D8979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, candidat_id INT DEFAULT NULL, recruiter_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6498D0EB82 (candidat_id), UNIQUE INDEX UNIQ_8D93D649156BE243 (recruiter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_job (user_id INT NOT NULL, job_id INT NOT NULL, INDEX IDX_10CE8173A76ED395 (user_id), INDEX IDX_10CE8173BE04EA9 (job_id), PRIMARY KEY(user_id, job_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidat ADD CONSTRAINT FK_6AB5B471A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE candidat_job ADD CONSTRAINT FK_93B2BA8C8D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE candidat_job ADD CONSTRAINT FK_93B2BA8CBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A167B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8F675F31B FOREIGN KEY (author_id) REFERENCES recruiter (id)');
        $this->addSql('ALTER TABLE job_user ADD CONSTRAINT FK_A5FA008BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_user ADD CONSTRAINT FK_A5FA008A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recruiter ADD CONSTRAINT FK_DE8633D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE recruiter ADD CONSTRAINT FK_DE8633D8979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498D0EB82 FOREIGN KEY (candidat_id) REFERENCES candidat (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
        $this->addSql('ALTER TABLE user_job ADD CONSTRAINT FK_10CE8173A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_job ADD CONSTRAINT FK_10CE8173BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidat DROP FOREIGN KEY FK_6AB5B471A76ED395');
        $this->addSql('ALTER TABLE candidat_job DROP FOREIGN KEY FK_93B2BA8C8D0EB82');
        $this->addSql('ALTER TABLE candidat_job DROP FOREIGN KEY FK_93B2BA8CBE04EA9');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A167B3B43D');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8F675F31B');
        $this->addSql('ALTER TABLE job_user DROP FOREIGN KEY FK_A5FA008BE04EA9');
        $this->addSql('ALTER TABLE job_user DROP FOREIGN KEY FK_A5FA008A76ED395');
        $this->addSql('ALTER TABLE recruiter DROP FOREIGN KEY FK_DE8633D8A76ED395');
        $this->addSql('ALTER TABLE recruiter DROP FOREIGN KEY FK_DE8633D8979B1AD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498D0EB82');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649156BE243');
        $this->addSql('ALTER TABLE user_job DROP FOREIGN KEY FK_10CE8173A76ED395');
        $this->addSql('ALTER TABLE user_job DROP FOREIGN KEY FK_10CE8173BE04EA9');
        $this->addSql('DROP TABLE candidat');
        $this->addSql('DROP TABLE candidat_job');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE job_user');
        $this->addSql('DROP TABLE recruiter');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_job');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
