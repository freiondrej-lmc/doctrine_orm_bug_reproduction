<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602105106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE main (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE main_other (main_id INT NOT NULL, other_id INT NOT NULL, PRIMARY KEY(main_id, other_id))');
        $this->addSql('CREATE INDEX IDX_7A048666627EA78A ON main_other (main_id)');
        $this->addSql('CREATE INDEX IDX_7A048666998D9879 ON main_other (other_id)');
        $this->addSql('CREATE TABLE other (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE main_other ADD CONSTRAINT FK_7A048666627EA78A FOREIGN KEY (main_id) REFERENCES main (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE main_other ADD CONSTRAINT FK_7A048666998D9879 FOREIGN KEY (other_id) REFERENCES other (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
    }
}
