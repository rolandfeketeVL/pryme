<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510091812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, user_id INT DEFAULT NULL, guestlist TINYINT(1) DEFAULT NULL, position INT DEFAULT NULL, INDEX IDX_FE38F84471F7E88B (event_id), INDEX IDX_FE38F844A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84471F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE gender gender SMALLINT NOT NULL, CHANGE street street VARCHAR(255) NOT NULL, CHANGE total_bookings total_bookings INT NOT NULL, CHANGE credits_remaining credits_remaining SMALLINT NOT NULL, CHANGE email_consent email_consent TINYINT(1) NOT NULL, CHANGE sms_consent sms_consent TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE appointment');
        $this->addSql('ALTER TABLE users CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE gender gender SMALLINT DEFAULT NULL, CHANGE street street VARCHAR(255) DEFAULT NULL, CHANGE total_bookings total_bookings INT DEFAULT NULL, CHANGE credits_remaining credits_remaining SMALLINT DEFAULT NULL, CHANGE email_consent email_consent TINYINT(1) DEFAULT NULL, CHANGE sms_consent sms_consent TINYINT(1) DEFAULT NULL');
    }
}
