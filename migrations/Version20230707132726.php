<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230707132726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece ADD pce_category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B235C1F387 FOREIGN KEY (pce_category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_44CA0B235C1F387 ON piece (pce_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B235C1F387');
        $this->addSql('DROP INDEX IDX_44CA0B235C1F387 ON piece');
        $this->addSql('ALTER TABLE piece DROP pce_category_id');
    }
}
