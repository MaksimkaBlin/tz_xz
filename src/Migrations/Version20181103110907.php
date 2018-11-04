<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103110907 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article DROP author, CHANGE content content LONGTEXT DEFAULT NULL, CHANGE slug slug VARCHAR(100) NOT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E66989D9B62 ON article (slug)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_23A0E66989D9B62 ON article');
        $this->addSql('ALTER TABLE article ADD author VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE slug slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE content content LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME NOT NULL');
    }
}
