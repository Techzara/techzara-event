<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190216220041 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tze_organisateur (id INT AUTO_INCREMENT NOT NULL, org_name VARCHAR(100) DEFAULT NULL, org_image VARCHAR(150) DEFAULT NULL, org_decription VARCHAR(255) DEFAULT NULL, org_responsabilite VARCHAR(100) DEFAULT NULL, actEvent INT NOT NULL, INDEX IDX_9039BB5A6FC3B45D (actEvent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tze_organisateur ADD CONSTRAINT FK_9039BB5A6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tze_organisateur');
    }
}
