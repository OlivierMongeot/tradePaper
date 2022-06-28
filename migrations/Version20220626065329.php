<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626065329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE wallet ADD token_id INT NOT NULL');
        // $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F41DEE7B9 FOREIGN KEY (token_id) REFERENCES token (id)');
        // $this->addSql('CREATE INDEX IDX_7C68921F41DEE7B9 ON wallet (token_id)');
        $this->addSql('DROP TABLE wallet');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F41DEE7B9');
        // $this->addSql('DROP INDEX IDX_7C68921F41DEE7B9 ON wallet');
        // $this->addSql('ALTER TABLE wallet DROP token_id');
    }
}
