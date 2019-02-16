<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190216191316 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tze_partenaires (id INT AUTO_INCREMENT NOT NULL, parte_entite VARCHAR(100) DEFAULT NULL, parte_image VARCHAR(100) DEFAULT NULL, parte_location VARCHAR(100) DEFAULT NULL, parte_contribution LONGTEXT DEFAULT NULL, actEvent INT NOT NULL, INDEX IDX_872FD8046FC3B45D (actEvent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tze_partenaires ADD CONSTRAINT FK_872FD8046FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tze_partenaires');
    }
}
