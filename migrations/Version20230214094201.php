<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214094201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (
            id INT AUTO_INCREMENT NOT NULL, 
            user_id INT DEFAULT NULL, 
            email VARCHAR(255) NOT NULL, 
            first_name VARCHAR(50) DEFAULT NULL, 
            guest_quantity INT NOT NULL, 
            allergy_list VARCHAR(255) DEFAULT NULL, 
            schedule DATETIME NOT NULL, 
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', 
            INDEX IDX_42C84955A76ED395 (user_id), 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
            $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP TABLE reservation');
    }
}
