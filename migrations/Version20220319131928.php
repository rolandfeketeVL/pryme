<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220319131928 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE benefits (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, credits SMALLINT NOT NULL, price SMALLINT NOT NULL, valability DATETIME NOT NULL, persons_no SMALLINT NOT NULL, minutes SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE membership_benefits (membership_id INT NOT NULL, benefits_id INT NOT NULL, INDEX IDX_8ABF850A1FB354CD (membership_id), INDEX IDX_8ABF850A731ED7DA (benefits_id), PRIMARY KEY(membership_id, benefits_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membership_benefits ADD CONSTRAINT FK_8ABF850A1FB354CD FOREIGN KEY (membership_id) REFERENCES membership (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE membership_benefits ADD CONSTRAINT FK_8ABF850A731ED7DA FOREIGN KEY (benefits_id) REFERENCES benefits (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membership_benefits DROP FOREIGN KEY FK_8ABF850A731ED7DA');
        $this->addSql('ALTER TABLE membership_benefits DROP FOREIGN KEY FK_8ABF850A1FB354CD');
        $this->addSql('DROP TABLE benefits');
        $this->addSql('DROP TABLE membership');
        $this->addSql('DROP TABLE membership_benefits');
    }
}
