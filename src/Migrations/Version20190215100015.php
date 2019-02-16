<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190215100015 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tze_email_newsletter RENAME INDEX uniq_ab2b3778d5d52dec TO UNIQ_3A08CB07D5D52DEC');
        $this->addSql('ALTER TABLE tze_message_newsletter_translation RENAME INDEX idx_5839731d2c2ac5d3 TO IDX_13D0B35A2C2AC5D3');
        $this->addSql('ALTER TABLE tze_slide ADD sld_event_title VARCHAR(100) DEFAULT NULL, ADD sld_event_second_title VARCHAR(100) DEFAULT NULL, ADD sld_intervenant VARCHAR(100) DEFAULT NULL, ADD sld_location VARCHAR(100) DEFAULT NULL, ADD sld_place VARCHAR(100) DEFAULT NULL, ADD sld_event_date DATETIME DEFAULT NULL, DROP sld_first_title, DROP sld_second_title, DROP sld_third_title');
        $this->addSql('ALTER TABLE tze_user RENAME INDEX idx_a98a6686cc5ef58d TO IDX_4B8D00C0158A5D9F');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tze_email_newsletter RENAME INDEX uniq_3a08cb07d5d52dec TO UNIQ_AB2B3778D5D52DEC');
        $this->addSql('ALTER TABLE tze_message_newsletter_translation RENAME INDEX idx_13d0b35a2c2ac5d3 TO IDX_5839731D2C2AC5D3');
        $this->addSql('ALTER TABLE tze_slide ADD sld_first_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD sld_second_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, ADD sld_third_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP sld_event_title, DROP sld_event_second_title, DROP sld_intervenant, DROP sld_location, DROP sld_place, DROP sld_event_date');
        $this->addSql('ALTER TABLE tze_user RENAME INDEX idx_4b8d00c0158a5d9f TO IDX_A98A6686CC5EF58D');
    }
}
