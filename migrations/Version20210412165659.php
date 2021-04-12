<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210412165659 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create entities tables';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admins (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A2E0150FE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', created_by_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, tags LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', published_at DATETIME DEFAULT NULL, gallery LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', description LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, commentable TINYINT(1) NOT NULL, see_also LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_BFDD3168B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_categories (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_category_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_DE004A0E796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', article_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_comment_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by_admin_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', created_by_student_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', content LONGTEXT NOT NULL, INDEX IDX_5F9E962A7294869C (article_id), INDEX IDX_5F9E962ABF2AF943 (parent_comment_id), INDEX IDX_5F9E962A64F1F4EE (created_by_admin_id), INDEX IDX_5F9E962AF8CD57FA (created_by_student_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resources (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, published_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, active TINYINT(1) NOT NULL, see_also LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resources_categories (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', parent_category_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_40381E3B796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, matricule INT NOT NULL, active TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A4698DB2E7927C74 (email), UNIQUE INDEX UNIQ_A4698DB212B2DC9C (matricule), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168B03A8386 FOREIGN KEY (created_by_id) REFERENCES admins (id)');
        $this->addSql('ALTER TABLE articles_categories ADD CONSTRAINT FK_DE004A0E796A8F92 FOREIGN KEY (parent_category_id) REFERENCES articles_categories (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962ABF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comments (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A64F1F4EE FOREIGN KEY (created_by_admin_id) REFERENCES admins (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF8CD57FA FOREIGN KEY (created_by_student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE resources_categories ADD CONSTRAINT FK_40381E3B796A8F92 FOREIGN KEY (parent_category_id) REFERENCES resources_categories (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168B03A8386');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A64F1F4EE');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A7294869C');
        $this->addSql('ALTER TABLE articles_categories DROP FOREIGN KEY FK_DE004A0E796A8F92');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962ABF2AF943');
        $this->addSql('ALTER TABLE resources_categories DROP FOREIGN KEY FK_40381E3B796A8F92');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF8CD57FA');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_categories');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE resources');
        $this->addSql('DROP TABLE resources_categories');
        $this->addSql('DROP TABLE students');
    }
}
