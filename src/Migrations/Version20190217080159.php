<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190217080159 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tze_organisateur DROP FOREIGN KEY FK_9039BB5A6FC3B45D');
        $this->addSql('ALTER TABLE tze_organisateur ADD CONSTRAINT FK_9039BB5A6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tze_event_activite DROP FOREIGN KEY FK_45682F156FC3B45D');
        $this->addSql('ALTER TABLE tze_event_activite CHANGE actEvent actEvent INT NOT NULL');
        $this->addSql('ALTER TABLE tze_event_activite ADD CONSTRAINT FK_45682F156FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tze_partenaires DROP FOREIGN KEY FK_872FD8046FC3B45D');
        $this->addSql('ALTER TABLE tze_partenaires ADD CONSTRAINT FK_872FD8046FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tze_participants DROP FOREIGN KEY FK_AA87A68C6FC3B45D');
        $this->addSql('ALTER TABLE tze_participants ADD CONSTRAINT FK_AA87A68C6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tze_event_activite DROP FOREIGN KEY FK_45682F156FC3B45D');
        $this->addSql('ALTER TABLE tze_event_activite CHANGE actEvent actEvent INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tze_event_activite ADD CONSTRAINT FK_45682F156FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
        $this->addSql('ALTER TABLE tze_organisateur DROP FOREIGN KEY FK_9039BB5A6FC3B45D');
        $this->addSql('ALTER TABLE tze_organisateur ADD CONSTRAINT FK_9039BB5A6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
        $this->addSql('ALTER TABLE tze_partenaires DROP FOREIGN KEY FK_872FD8046FC3B45D');
        $this->addSql('ALTER TABLE tze_partenaires ADD CONSTRAINT FK_872FD8046FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
        $this->addSql('ALTER TABLE tze_participants DROP FOREIGN KEY FK_AA87A68C6FC3B45D');
        $this->addSql('ALTER TABLE tze_participants ADD CONSTRAINT FK_AA87A68C6FC3B45D FOREIGN KEY (actEvent) REFERENCES tze_slide (id)');
    }
}
