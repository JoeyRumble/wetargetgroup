<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250630153108 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE page ADD subtitle1 VARCHAR(255) DEFAULT NULL, ADD text2 LONGTEXT DEFAULT NULL, ADD subtitle2 VARCHAR(255) DEFAULT NULL, ADD subtitle3 VARCHAR(255) DEFAULT NULL, ADD text3 LONGTEXT DEFAULT NULL, ADD subtitle4 VARCHAR(255) DEFAULT NULL, ADD text4 LONGTEXT DEFAULT NULL, ADD subtitle5 VARCHAR(255) DEFAULT NULL, ADD text5 LONGTEXT DEFAULT NULL, ADD subtitle6 VARCHAR(255) DEFAULT NULL, ADD text6 LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE page DROP subtitle1, DROP text2, DROP subtitle2, DROP subtitle3, DROP text3, DROP subtitle4, DROP text4, DROP subtitle5, DROP text5, DROP subtitle6, DROP text6
        SQL);
    }
}
