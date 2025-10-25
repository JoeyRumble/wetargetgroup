<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709161944 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, categories JSON DEFAULT NULL, slug VARCHAR(255) NOT NULL, image_file_name VARCHAR(255) DEFAULT NULL, subpage_title_first VARCHAR(255) DEFAULT NULL, subpage_text_first LONGTEXT DEFAULT NULL, subpage_title_second VARCHAR(255) DEFAULT NULL, subpage_text_second LONGTEXT DEFAULT NULL, subpage_image_second_file_name VARCHAR(255) DEFAULT NULL, subpage_title_third VARCHAR(255) DEFAULT NULL, subpage_text_third LONGTEXT DEFAULT NULL, subpage_image_third_file_name VARCHAR(255) DEFAULT NULL, subpage_title_fourth VARCHAR(255) DEFAULT NULL, subpage_text_fourth LONGTEXT DEFAULT NULL, subpage_image_fourth_file_name VARCHAR(255) DEFAULT NULL, logo_file_name VARCHAR(255) DEFAULT NULL, show_on_homepage TINYINT(1) DEFAULT 0 NOT NULL, position INT DEFAULT 0 NOT NULL, updated_at DATETIME DEFAULT NULL, type VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page ADD subtitle1 VARCHAR(255) DEFAULT NULL, ADD text2 LONGTEXT DEFAULT NULL, ADD subtitle2 VARCHAR(255) DEFAULT NULL, ADD subtitle3 VARCHAR(255) DEFAULT NULL, ADD text3 LONGTEXT DEFAULT NULL, ADD subtitle4 VARCHAR(255) DEFAULT NULL, ADD text4 LONGTEXT DEFAULT NULL, ADD subtitle5 VARCHAR(255) DEFAULT NULL, ADD text5 LONGTEXT DEFAULT NULL, ADD subtitle6 VARCHAR(255) DEFAULT NULL, ADD text6 LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE project
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE page DROP subtitle1, DROP text2, DROP subtitle2, DROP subtitle3, DROP text3, DROP subtitle4, DROP text4, DROP subtitle5, DROP text5, DROP subtitle6, DROP text6
        SQL);
    }
}
