<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124133554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` RENAME INDEX uniq_f5299398aea34913 TO UNIQ_34E8BC9CAEA34913');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f52993986d72b15c TO IDX_34E8BC9C6D72B15C');
        $this->addSql('ALTER TABLE `order` RENAME INDEX idx_f5299398a76ed395 TO IDX_34E8BC9CA76ED395');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `Order` RENAME INDEX idx_34e8bc9c6d72b15c TO IDX_F52993986D72B15C');
        $this->addSql('ALTER TABLE `Order` RENAME INDEX idx_34e8bc9ca76ed395 TO IDX_F5299398A76ED395');
        $this->addSql('ALTER TABLE `Order` RENAME INDEX uniq_34e8bc9caea34913 TO UNIQ_F5299398AEA34913');
        $this->addSql('ALTER TABLE `user` DROP is_verified');
    }
}
