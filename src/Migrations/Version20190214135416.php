<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190214135416 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dit_message_newsletter_translation DROP FOREIGN KEY FK_5839731D2C2AC5D3');
        $this->addSql('ALTER TABLE dit_user DROP FOREIGN KEY FK_A98A6686CC5EF58D');
        $this->addSql('CREATE TABLE tze_email_newsletter (id INT AUTO_INCREMENT NOT NULL, nws_email VARCHAR(45) NOT NULL, nws_subscribed TINYINT(1) DEFAULT \'1\', UNIQUE INDEX UNIQ_3A08CB07D5D52DEC (nws_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tze_message_newsletter (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tze_message_newsletter_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, message_newsletter_title VARCHAR(255) NOT NULL, message_newsletter_content LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_13D0B35A2C2AC5D3 (translatable_id), UNIQUE INDEX tze_message_newsletter_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tze_role (id INT AUTO_INCREMENT NOT NULL, rl_name VARCHAR(45) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tze_slide (id INT AUTO_INCREMENT NOT NULL, sld_first_title VARCHAR(255) DEFAULT NULL, sld_second_title VARCHAR(255) DEFAULT NULL, sld_third_title VARCHAR(255) DEFAULT NULL, sld_image_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tze_user (id INT AUTO_INCREMENT NOT NULL, tze_role_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', usr_firstname VARCHAR(255) DEFAULT NULL, usr_lastname VARCHAR(255) DEFAULT NULL, usr_address VARCHAR(255) DEFAULT NULL, usr_date_create DATETIME DEFAULT NULL, usr_date_update DATETIME DEFAULT NULL, usr_phone VARCHAR(45) DEFAULT NULL, usr_photo VARCHAR(255) DEFAULT NULL, usr_is_valid TINYINT(1) NOT NULL, INDEX IDX_4B8D00C0158A5D9F (tze_role_id), UNIQUE INDEX username_canonical_UNIQUE (username_canonical), UNIQUE INDEX email_canonical_UNIQUE (email_canonical), UNIQUE INDEX confirmation_token_UNIQUE (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tze_message_newsletter_translation ADD CONSTRAINT FK_13D0B35A2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES tze_message_newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tze_user ADD CONSTRAINT FK_4B8D00C0158A5D9F FOREIGN KEY (tze_role_id) REFERENCES tze_role (id)');
        $this->addSql('DROP TABLE dit_email_newsletter');
        $this->addSql('DROP TABLE dit_message_newsletter');
        $this->addSql('DROP TABLE dit_message_newsletter_translation');
        $this->addSql('DROP TABLE dit_role');
        $this->addSql('DROP TABLE dit_slide');
        $this->addSql('DROP TABLE dit_user');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tze_message_newsletter_translation DROP FOREIGN KEY FK_13D0B35A2C2AC5D3');
        $this->addSql('ALTER TABLE tze_user DROP FOREIGN KEY FK_4B8D00C0158A5D9F');
        $this->addSql('CREATE TABLE dit_email_newsletter (id INT AUTO_INCREMENT NOT NULL, nws_email VARCHAR(45) NOT NULL COLLATE utf8_unicode_ci, nws_subscribed TINYINT(1) DEFAULT \'1\', UNIQUE INDEX UNIQ_AB2B3778D5D52DEC (nws_email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dit_message_newsletter (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dit_message_newsletter_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, message_newsletter_title VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, message_newsletter_content LONGTEXT NOT NULL COLLATE utf8_unicode_ci, locale VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX dit_message_newsletter_translation_unique_translation (translatable_id, locale), INDEX IDX_5839731D2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dit_role (id INT AUTO_INCREMENT NOT NULL, rl_name VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dit_slide (id INT AUTO_INCREMENT NOT NULL, sld_first_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, sld_second_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, sld_third_title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, sld_image_url VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dit_user (id INT AUTO_INCREMENT NOT NULL, dit_role_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, username_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, email_canonical VARCHAR(180) NOT NULL COLLATE utf8_unicode_ci, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL COLLATE utf8_unicode_ci, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:array)\', usr_firstname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, usr_lastname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, usr_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, usr_date_create DATETIME DEFAULT NULL, usr_date_update DATETIME DEFAULT NULL, usr_phone VARCHAR(45) DEFAULT NULL COLLATE utf8_unicode_ci, usr_photo VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, usr_is_valid TINYINT(1) NOT NULL, UNIQUE INDEX username_canonical_UNIQUE (username_canonical), UNIQUE INDEX email_canonical_UNIQUE (email_canonical), UNIQUE INDEX confirmation_token_UNIQUE (confirmation_token), INDEX IDX_A98A6686CC5EF58D (dit_role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dit_message_newsletter_translation ADD CONSTRAINT FK_5839731D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dit_message_newsletter (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dit_user ADD CONSTRAINT FK_A98A6686CC5EF58D FOREIGN KEY (dit_role_id) REFERENCES dit_role (id)');
        $this->addSql('DROP TABLE tze_email_newsletter');
        $this->addSql('DROP TABLE tze_message_newsletter');
        $this->addSql('DROP TABLE tze_message_newsletter_translation');
        $this->addSql('DROP TABLE tze_role');
        $this->addSql('DROP TABLE tze_slide');
        $this->addSql('DROP TABLE tze_user');
    }
}
