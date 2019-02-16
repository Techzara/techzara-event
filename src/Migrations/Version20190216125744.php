<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190216125744 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tze_participants (id INT AUTO_INCREMENT NOT NULL, part_universite VARCHAR(100) DEFAULT NULL, part_image VARCHAR(100) DEFAULT NULL, part_team VARCHAR(100) DEFAULT NULL, part_description LONGTEXT DEFAULT NULL, actEvent INT DEFAULT NULL, INDEX IDX_AA87A68C6FC3B45D (actEvent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tze_participants ADD CONSTRAINT FK_AA87A68C6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tze_participants');
    }
}
