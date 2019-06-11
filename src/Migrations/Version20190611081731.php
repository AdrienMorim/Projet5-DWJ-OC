<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190611081731 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE work ADD image_id INT DEFAULT NULL, DROP image, DROP image_alt');
        $this->addSql('ALTER TABLE work ADD CONSTRAINT FK_534E68803DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_534E68803DA5256D ON work (image_id)');
        $this->addSql('ALTER TABLE category CHANGE title name VARCHAR(20) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE name title VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE work DROP FOREIGN KEY FK_534E68803DA5256D');
        $this->addSql('DROP INDEX UNIQ_534E68803DA5256D ON work');
        $this->addSql('ALTER TABLE work ADD image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD image_alt VARCHAR(60) NOT NULL COLLATE utf8mb4_unicode_ci, DROP image_id');
    }
}
