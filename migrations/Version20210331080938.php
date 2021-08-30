<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331080938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adresses (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, full_name VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, adresse CLOB NOT NULL, compl_adresse CLOB DEFAULT NULL, city VARCHAR(255) NOT NULL, code_postal INTEGER NOT NULL, pays VARCHAR(255) NOT NULL, telephone INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_EF192552A76ED395 ON adresses (user_id)');
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB NOT NULL, mor_information CLOB DEFAULT NULL, prix DOUBLE PRECISION NOT NULL, is_best_seller BOOLEAN NOT NULL, is_new_arival BOOLEAN NOT NULL, is_featured BOOLEAN DEFAULT NULL, is_special_offer BOOLEAN DEFAULT NULL, image VARCHAR(255) NOT NULL, quantity INTEGER NOT NULL, created_at DATETIME NOT NULL, tags CLOB DEFAULT NULL, slug VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE product_category (product_id INTEGER NOT NULL, category_id INTEGER NOT NULL, PRIMARY KEY(product_id, category_id))');
        $this->addSql('CREATE INDEX IDX_CDFC73564584665A ON product_category (product_id)');
        $this->addSql('CREATE INDEX IDX_CDFC735612469DE2 ON product_category (category_id)');
        $this->addSql('CREATE TABLE related_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_EC53CE084584665A ON related_product (product_id)');
        $this->addSql('CREATE TABLE reset_password_request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , expires_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('CREATE TABLE reviews_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, note INTEGER NOT NULL, comment CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_E0851D6CA76ED395 ON reviews_product (user_id)');
        $this->addSql('CREATE INDEX IDX_E0851D6C4584665A ON reviews_product (product_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adresses');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE related_product');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE reviews_product');
        $this->addSql('DROP TABLE user');
    }
}
