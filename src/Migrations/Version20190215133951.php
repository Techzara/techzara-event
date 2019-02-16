<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190215133951 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tze_event_activite (id INT AUTO_INCREMENT NOT NULL, act_title VARCHAR(100) DEFAULT NULL, act_description LONGTEXT DEFAULT NULL, act_debut LONGTEXT DEFAULT NULL, act_fin LONGTEXT DEFAULT NULL, act_image VARCHAR(255) DEFAULT NULL, actEvent INT DEFAULT NULL, INDEX IDX_45682F156FC3B45D (actEvent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tze_event_activite ADD CONSTRAINT FK_45682F156FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tze_event_activite');
    }
}
