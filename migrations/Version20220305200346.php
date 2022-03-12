<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305200346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A763C71EE75 FOREIGN KEY (donation_documents_id) REFERENCES donation_document (id)');
        $this->addSql('CREATE INDEX IDX_D8698A763C71EE75 ON document (donation_documents_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A763C71EE75');
        $this->addSql('DROP INDEX IDX_D8698A763C71EE75 ON document');
    }
}
