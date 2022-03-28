<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220328181858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE components (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, device_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE devices (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, vehicle_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE status (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, component_id INTEGER NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE vehicles (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE components');
        $this->addSql('DROP TABLE devices');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE vehicles');
    }
}
