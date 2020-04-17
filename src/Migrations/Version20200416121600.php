<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200416121600 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE more_information more_information VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE basket CHANGE user_id user_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE shipping_address_id shipping_address_id INT DEFAULT NULL, CHANGE billing_address_id billing_address_id INT DEFAULT NULL, CHANGE seller_id seller_id INT DEFAULT NULL, CHANGE buyer_id buyer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product DROP INDEX UNIQ_2530ADE64584665A, ADD INDEX IDX_2530ADE64584665A (product_id)');
        $this->addSql('ALTER TABLE order_product CHANGE my_order_id my_order_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE shipping_address_id shipping_address_id INT DEFAULT NULL, CHANGE billing_address_id billing_address_id INT DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE address CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE more_information more_information VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE basket CHANGE user_id user_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE shipping_address_id shipping_address_id INT DEFAULT NULL, CHANGE billing_address_id billing_address_id INT DEFAULT NULL, CHANGE seller_id seller_id INT DEFAULT NULL, CHANGE buyer_id buyer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product DROP INDEX IDX_2530ADE64584665A, ADD UNIQUE INDEX UNIQ_2530ADE64584665A (product_id)');
        $this->addSql('ALTER TABLE order_product CHANGE my_order_id my_order_id INT DEFAULT NULL, CHANGE product_id product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE user_id user_id INT DEFAULT NULL, CHANGE category_id category_id INT DEFAULT NULL, CHANGE quantity quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE shipping_address_id shipping_address_id INT DEFAULT NULL, CHANGE billing_address_id billing_address_id INT DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
