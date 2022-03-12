<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305202834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donation_document (id INT AUTO_INCREMENT NOT NULL, donation_id INT NOT NULL, UNIQUE INDEX UNIQ_132295064DC1279C (donation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation_document ADD CONSTRAINT FK_132295064DC1279C FOREIGN KEY (donation_id) REFERENCES donation (id)');
        $this->addSql('ALTER TABLE document CHANGE donation_documents_id corresponding_donation_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76920A4D71 FOREIGN KEY (corresponding_donation_id) REFERENCES donation_document (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76920A4D71 ON document (corresponding_donation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76920A4D71');
        $this->addSql('DROP TABLE donation_document');
        $this->addSql('DROP INDEX IDX_D8698A76920A4D71 ON document');
        $this->addSql('ALTER TABLE document CHANGE corresponding_donation_id donation_documents_id INT NOT NULL');
    }
}
