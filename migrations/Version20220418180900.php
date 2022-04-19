<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418180900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE membership ADD valability SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE gender gender SMALLINT NOT NULL, CHANGE street street VARCHAR(255) NOT NULL, CHANGE total_bookings total_bookings INT NOT NULL, CHANGE credits_remaining credits_remaining SMALLINT NOT NULL, CHANGE email_consent email_consent TINYINT(1) NOT NULL, CHANGE sms_consent sms_consent TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE benefits CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE membership DROP valability, CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE users CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gender gender SMALLINT DEFAULT NULL, CHANGE street street VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE state state VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE zip zip VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE total_bookings total_bookings INT DEFAULT NULL, CHANGE credits_remaining credits_remaining SMALLINT DEFAULT NULL, CHANGE email_consent email_consent TINYINT(1) DEFAULT NULL, CHANGE sms_consent sms_consent TINYINT(1) DEFAULT NULL');
    }
}
