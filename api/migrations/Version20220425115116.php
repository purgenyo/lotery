<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425115116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_prize_loyalty_point (id CHAR(36) NOT NULL COMMENT \'(DC2Type:UserPrizes_LoyaltyPointPrize_id)\', manager_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:UserPrizes_manager_id_type)\', amount INT NOT NULL COMMENT \'(DC2Type:UserPrizes_MoneyPrize_amount_type)\', statusEnum INT DEFAULT 1 NOT NULL COMMENT \'(DC2Type:UserPrizes_delivery_status_enum_type)\', INDEX IDX_6F3EF3D8783E3463 (manager_id), UNIQUE INDEX unique_id (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_prize_loyalty_point ADD CONSTRAINT FK_6F3EF3D8783E3463 FOREIGN KEY (manager_id) REFERENCES user_prize_manager (id)');
        $this->addSql('CREATE UNIQUE INDEX unique_user_id ON user_prize_manager (userId)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_prize_loyalty_point');
        $this->addSql('DROP INDEX unique_user_id ON user_prize_manager');
    }
}
