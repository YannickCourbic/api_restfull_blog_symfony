<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605145834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE style_sheet (id INT GENERATED BY DEFAULT AS IDENTITY NOT NULL, font_family VARCHAR(255) NOT NULL, font_size VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, background VARCHAR(255) NOT NULL, background_image VARCHAR(255) DEFAULT NULL, border VARCHAR(255) NOT NULL, border_radius VARCHAR(255) NOT NULL, line_height VARCHAR(255) NOT NULL, letter_spacing VARCHAR(255) DEFAULT NULL, shadow VARCHAR(255) DEFAULT NULL, background_gradient VARCHAR(255) DEFAULT NULL, height VARCHAR(255) DEFAULT NULL, width VARCHAR(255) DEFAULT NULL, position_type VARCHAR(255) DEFAULT NULL, position_top VARCHAR(255) DEFAULT NULL, position_bottom VARCHAR(255) DEFAULT NULL, position_left VARCHAR(255) DEFAULT NULL, position_right VARCHAR(255) DEFAULT NULL, margin_top VARCHAR(255) DEFAULT NULL, margin_bottom VARCHAR(255) DEFAULT NULL, margin_left VARCHAR(255) DEFAULT NULL, margin_right VARCHAR(255) DEFAULT NULL, padding_top VARCHAR(255) DEFAULT NULL, padding_bottom VARCHAR(255) DEFAULT NULL, padding_left VARCHAR(255) DEFAULT NULL, padding_right VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE style_sheet');
    }
}
