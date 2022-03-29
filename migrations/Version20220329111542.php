<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220329111542 extends AbstractMigration
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
        //insert pre-data
        $this->addSql('INSERT INTO vehicles (type, name) VALUES
            ("bus","Autobus 307"),
            ("bus","Autobus 308"),
            ("tram","Tramwaj 336"),
            ("tram","Tramwaj 337"),
            ("train","Pociąg 14")');
        $this->addSql('INSERT INTO devices (vehicle_id, type, name) VALUES
            (1,"ticket_machine","Biletomat nr 1"),
            (1,"ticket_machine","Biletomat nr 2"),
            (2,"ticket_machine","Biletomat nr 1"),
            (2,"ticket_machine","Biletomat nr 2"),
            (3,"ticket_machine","Biletomat nr 1"),
            (3,"ticket_machine","Biletomat nr 2"),
            (4,"ticket_machine","Biletomat nr 1"),
            (4,"ticket_machine","Biletomat nr 2")');
        $this->addSql('INSERT INTO components (device_id, type, name) VALUES
            (1, "payment_terminal", "Trminal płatniczy"),
            (1, "qr_code_reader", "Czytnik kodów QR"),
            (1, "printer", "Drukarka termiczna"),
            (2, "payment_terminal", "Trminal płatniczy"),
            (2, "qr_code_reader", "Czytnik kodów QR"),
            (2, "printer", "Drukarka termiczna"),
            (3, "payment_terminal", "Trminal płatniczy"),
            (3, "qr_code_reader", "Czytnik kodów QR"),
            (3, "printer", "Drukarka termiczna"),
            (4, "payment_terminal", "Trminal płatniczy"),
            (4, "qr_code_reader", "Czytnik kodów QR"),
            (4, "printer", "Drukarka termiczna"),
            (5, "payment_terminal", "Trminal płatniczy"),
            (5, "qr_code_reader", "Czytnik kodów QR"),
            (5, "printer", "Drukarka termiczna"),
            (6, "payment_terminal", "Trminal płatniczy"),
            (6, "qr_code_reader", "Czytnik kodów QR"),
            (6, "printer", "Drukarka termiczna"),
            (7, "payment_terminal", "Trminal płatniczy"),
            (7, "qr_code_reader", "Czytnik kodów QR"),
            (7, "printer", "Drukarka termiczna",),
            (8, "payment_terminal", "Trminal płatniczy"),
            (8, "qr_code_reader", "Czytnik kodów QR"),
            (8, "printer", "Drukarka termiczna")'); 
        $this->addSql('INSERT INTO status (component_id, type, description) VALUES
            (1,"error","Brak zasilania"),
            (21,"warning","Zacięcie papieru")');   
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
