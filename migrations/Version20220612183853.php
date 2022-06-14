<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612183853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE action (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exchange (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trade (id INT AUTO_INCREMENT NOT NULL, action_id INT NOT NULL, token_id INT NOT NULL, user_id INT NOT NULL, exchange_id INT DEFAULT NULL, token_price_transaction DOUBLE PRECISION NOT NULL, quantity DOUBLE PRECISION NOT NULL, fee DOUBLE PRECISION DEFAULT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_7E1A43669D32F035 (action_id), INDEX IDX_7E1A436641DEE7B9 (token_id), INDEX IDX_7E1A4366A76ED395 (user_id), INDEX IDX_7E1A436668AFD1A0 (exchange_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A43669D32F035 FOREIGN KEY (action_id) REFERENCES action (id)');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A436641DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A4366A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE trade ADD CONSTRAINT FK_7E1A436668AFD1A0 FOREIGN KEY (exchange_id) REFERENCES exchange (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A43669D32F035');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A436668AFD1A0');
        $this->addSql('ALTER TABLE trade DROP FOREIGN KEY FK_7E1A436641DEE7B9');
        $this->addSql('DROP TABLE action');
        $this->addSql('DROP TABLE exchange');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE trade');
    }
}
