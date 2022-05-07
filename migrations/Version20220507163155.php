<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220507163155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA71FB354CD');
        $this->addSql('DROP INDEX IDX_3BAE0AA71FB354CD ON event');
        $this->addSql('ALTER TABLE event CHANGE membership_id memberships_group_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA73F39ACB0 FOREIGN KEY (memberships_group_id) REFERENCES membership_group (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA73F39ACB0 ON event (memberships_group_id)');
        $this->addSql('ALTER TABLE users CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE gender gender SMALLINT NOT NULL, CHANGE street street VARCHAR(255) NOT NULL, CHANGE total_bookings total_bookings INT NOT NULL, CHANGE credits_remaining credits_remaining SMALLINT NOT NULL, CHANGE email_consent email_consent TINYINT(1) NOT NULL, CHANGE sms_consent sms_consent TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA73F39ACB0');
        $this->addSql('DROP INDEX IDX_3BAE0AA73F39ACB0 ON event');
        $this->addSql('ALTER TABLE event CHANGE memberships_group_id membership_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA71FB354CD FOREIGN KEY (membership_id) REFERENCES membership (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA71FB354CD ON event (membership_id)');
        $this->addSql('ALTER TABLE users CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE gender gender SMALLINT DEFAULT NULL, CHANGE street street VARCHAR(255) DEFAULT NULL, CHANGE total_bookings total_bookings INT DEFAULT NULL, CHANGE credits_remaining credits_remaining SMALLINT DEFAULT NULL, CHANGE email_consent email_consent TINYINT(1) DEFAULT NULL, CHANGE sms_consent sms_consent TINYINT(1) DEFAULT NULL');
    }
}
