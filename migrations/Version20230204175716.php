<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230204175716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE daily_schedule (
            id INT AUTO_INCREMENT NOT NULL, 
            opening_time TIME NOT NULL, 
            closing_time TIME NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE image_gallery (
            id INT AUTO_INCREMENT NOT NULL, 
            title VARCHAR(100) NOT NULL, 
            file_name VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE meal_menu (
            id INT AUTO_INCREMENT NOT NULL, 
            title VARCHAR(100) NOT NULL, 
            short_description VARCHAR(255) DEFAULT NULL, 
            description LONGTEXT NOT NULL, 
            price DECIMAL NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE settings (
            id INT AUTO_INCREMENT NOT NULL, 
            item VARCHAR(255) NOT NULL, 
            description VARCHAR(255) NOT NULL, 
            value VARCHAR(255) NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE week_day (
            id INT AUTO_INCREMENT NOT NULL, 
            title VARCHAR(20) NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE week_day_daily_schedule (
            week_day_id INT NOT NULL, 
            daily_schedule_id INT NOT NULL, 
            INDEX IDX_14150AD47DB83875 (week_day_id), 
            INDEX IDX_14150AD4704D11CA (daily_schedule_id), 
            PRIMARY KEY(week_day_id, daily_schedule_id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE week_day_daily_schedule ADD CONSTRAINT FK_14150AD47DB83875 FOREIGN KEY (week_day_id) REFERENCES week_day (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE week_day_daily_schedule ADD CONSTRAINT FK_14150AD4704D11CA FOREIGN KEY (daily_schedule_id) REFERENCES daily_schedule (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE week_day_daily_schedule DROP FOREIGN KEY FK_14150AD47DB83875');
        $this->addSql('ALTER TABLE week_day_daily_schedule DROP FOREIGN KEY FK_14150AD4704D11CA');
        $this->addSql('DROP TABLE daily_schedule');
        $this->addSql('DROP TABLE image_gallery');
        $this->addSql('DROP TABLE meal_menu');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE week_day');
        $this->addSql('DROP TABLE week_day_daily_schedule');
        $this->addSql('ALTER TABLE user CHANGE created_at created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }
}
