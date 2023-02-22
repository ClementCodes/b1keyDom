<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230220224959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE life_place (id INT NOT NULL, pieces INT DEFAULT NULL, bathroom INT DEFAULT NULL, living_room INT DEFAULT NULL, wc INT DEFAULT NULL, rooms INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, life_place_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, zip_code INT NOT NULL, email VARCHAR(180) NOT NULL, street VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, date_in DATE NOT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D64964061326 ON "user" (life_place_id)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D64964061326 FOREIGN KEY (life_place_id) REFERENCES life_place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D64964061326');
        $this->addSql('DROP TABLE life_place');
        $this->addSql('DROP TABLE "user"');
    }
}
