<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210104220703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE role1 (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role1_user (role1_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_159420579DAC172 (role1_id), INDEX IDX_15942057A76ED395 (user_id), PRIMARY KEY(role1_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role1_user ADD CONSTRAINT FK_159420579DAC172 FOREIGN KEY (role1_id) REFERENCES role1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role1_user ADD CONSTRAINT FK_15942057A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE role1_user DROP FOREIGN KEY FK_159420579DAC172');
        $this->addSql('DROP TABLE role1');
        $this->addSql('DROP TABLE role1_user');
    }
}
