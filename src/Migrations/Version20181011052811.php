<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181011052811 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE mc_movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, release_date DATETIME NOT NULL, overview LONGTEXT NOT NULL, poster_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_user (movie_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_7EF5F7448F93B6FC (movie_id), INDEX IDX_7EF5F744A76ED395 (user_id), PRIMARY KEY(movie_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mc_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EFF9DEE0F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_user ADD CONSTRAINT FK_7EF5F7448F93B6FC FOREIGN KEY (movie_id) REFERENCES mc_movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_user ADD CONSTRAINT FK_7EF5F744A76ED395 FOREIGN KEY (user_id) REFERENCES mc_user (id) ON DELETE CASCADE');
        $this->addSql('INSERT ignore INTO mc_user (username) VALUES ("neo")');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movie_user DROP FOREIGN KEY FK_7EF5F7448F93B6FC');
        $this->addSql('ALTER TABLE movie_user DROP FOREIGN KEY FK_7EF5F744A76ED395');
        $this->addSql('DROP TABLE mc_movie');
        $this->addSql('DROP TABLE movie_user');
        $this->addSql('DROP TABLE mc_user');
    }
}
