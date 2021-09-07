<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210831154613 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, reference VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, transproteur_name VARCHAR(255) NOT NULL, transport_price DOUBLE PRECISION NOT NULL, adresse_livraison CLOB NOT NULL, is_paider BOOLEAN NOT NULL, more_informations CLOB DEFAULT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON "order" (user_id)');
        $this->addSql('CREATE TABLE order_detaiils (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, orders_id INTEGER NOT NULL, product_name VARCHAR(255) NOT NULL, product_price DOUBLE PRECISION NOT NULL, quantity INTEGER NOT NULL, sub_total_ht DOUBLE PRECISION NOT NULL, taxe DOUBLE PRECISION NOT NULL, sub_total_ttc DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3C78ADFACFFE9AD6 ON order_detaiils (orders_id)');
        $this->addSql('DROP INDEX IDX_EF192552A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adresses AS SELECT id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone FROM adresses');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('CREATE TABLE adresses (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL COLLATE BINARY, company VARCHAR(255) DEFAULT NULL COLLATE BINARY, adresse CLOB NOT NULL COLLATE BINARY, compl_adresse CLOB DEFAULT NULL COLLATE BINARY, city VARCHAR(255) NOT NULL COLLATE BINARY, code_postal INTEGER NOT NULL, pays VARCHAR(255) NOT NULL COLLATE BINARY, telephone INTEGER NOT NULL, CONSTRAINT FK_EF192552A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO adresses (id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone) SELECT id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone FROM __temp__adresses');
        $this->addSql('DROP TABLE __temp__adresses');
        $this->addSql('CREATE INDEX IDX_EF192552A76ED395 ON adresses (user_id)');
        $this->addSql('DROP INDEX IDX_CDFC735612469DE2');
        $this->addSql('DROP INDEX IDX_CDFC73564584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_category AS SELECT product_id, category_id FROM product_category');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('CREATE TABLE product_category (product_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(product_id, category_id), CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product_category (product_id, category_id) SELECT product_id, category_id FROM __temp__product_category');
        $this->addSql('DROP TABLE __temp__product_category');
        $this->addSql('CREATE INDEX IDX_CDFC735612469DE2 ON product_category (category_id)');
        $this->addSql('CREATE INDEX IDX_CDFC73564584665A ON product_category (product_id)');
        $this->addSql('DROP INDEX IDX_EC53CE084584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__related_product AS SELECT id, product_id FROM related_product');
        $this->addSql('DROP TABLE related_product');
        $this->addSql('CREATE TABLE related_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_EC53CE084584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO related_product (id, product_id) SELECT id, product_id FROM __temp__related_product');
        $this->addSql('DROP TABLE __temp__related_product');
        $this->addSql('CREATE INDEX IDX_EC53CE084584665A ON related_product (product_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL COLLATE BINARY, hashed_token VARCHAR(100) NOT NULL COLLATE BINARY, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_E0851D6C4584665A');
        $this->addSql('DROP INDEX IDX_E0851D6CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews_product AS SELECT id, user_id, product_id, note, comment FROM reviews_product');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('CREATE TABLE reviews_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, note INTEGER NOT NULL, comment CLOB DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_E0851D6CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E0851D6C4584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO reviews_product (id, user_id, product_id, note, comment) SELECT id, user_id, product_id, note, comment FROM __temp__reviews_product');
        $this->addSql('DROP TABLE __temp__reviews_product');
        $this->addSql('CREATE INDEX IDX_E0851D6C4584665A ON reviews_product (product_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6CA76ED395 ON reviews_product (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_detaiils');
        $this->addSql('DROP INDEX IDX_EF192552A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__adresses AS SELECT id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone FROM adresses');
        $this->addSql('DROP TABLE adresses');
        $this->addSql('CREATE TABLE adresses (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, adresse CLOB NOT NULL, compl_adresse CLOB DEFAULT NULL, city VARCHAR(255) NOT NULL, code_postal INTEGER NOT NULL, pays VARCHAR(255) NOT NULL, telephone INTEGER NOT NULL)');
        $this->addSql('INSERT INTO adresses (id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone) SELECT id, user_id, full_name, company, adresse, compl_adresse, city, code_postal, pays, telephone FROM __temp__adresses');
        $this->addSql('DROP TABLE __temp__adresses');
        $this->addSql('CREATE INDEX IDX_EF192552A76ED395 ON adresses (user_id)');
        $this->addSql('DROP INDEX IDX_CDFC73564584665A');
        $this->addSql('DROP INDEX IDX_CDFC735612469DE2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product_category AS SELECT product_id, category_id FROM product_category');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('CREATE TABLE product_category (product_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(product_id, category_id))');
        $this->addSql('INSERT INTO product_category (product_id, category_id) SELECT product_id, category_id FROM __temp__product_category');
        $this->addSql('DROP TABLE __temp__product_category');
        $this->addSql('CREATE INDEX IDX_CDFC73564584665A ON product_category (product_id)');
        $this->addSql('CREATE INDEX IDX_CDFC735612469DE2 ON product_category (category_id)');
        $this->addSql('DROP INDEX IDX_EC53CE084584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__related_product AS SELECT id, product_id FROM related_product');
        $this->addSql('DROP TABLE related_product');
        $this->addSql('CREATE TABLE related_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO related_product (id, product_id) SELECT id, product_id FROM __temp__related_product');
        $this->addSql('DROP TABLE __temp__related_product');
        $this->addSql('CREATE INDEX IDX_EC53CE084584665A ON related_product (product_id)');
        $this->addSql('DROP INDEX IDX_7CE748AA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reset_password_request AS SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM reset_password_request');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO reset_password_request (id, user_id, selector, hashed_token, requested_at, expires_at) SELECT id, user_id, selector, hashed_token, requested_at, expires_at FROM __temp__reset_password_request');
        $this->addSql('DROP TABLE __temp__reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('DROP INDEX IDX_E0851D6CA76ED395');
        $this->addSql('DROP INDEX IDX_E0851D6C4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__reviews_product AS SELECT id, user_id, product_id, note, comment FROM reviews_product');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('CREATE TABLE reviews_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, note INTEGER NOT NULL, comment CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO reviews_product (id, user_id, product_id, note, comment) SELECT id, user_id, product_id, note, comment FROM __temp__reviews_product');
        $this->addSql('DROP TABLE __temp__reviews_product');
        $this->addSql('CREATE INDEX IDX_E0851D6CA76ED395 ON reviews_product (user_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6C4584665A ON reviews_product (product_id)');
    }
}
