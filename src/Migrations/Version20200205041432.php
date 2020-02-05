<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205041432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE groupe (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, niveau INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, route VARCHAR(255) DEFAULT NULL, icon VARCHAR(255) DEFAULT NULL, position INT NOT NULL, is_active TINYINT(1) NOT NULL, is_route_valid TINYINT(1) NOT NULL, niveau_permission INT NOT NULL, INDEX IDX_7D053A93727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_groupe (menu_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_D7FED4F9CCD7E912 (menu_id), INDEX IDX_D7FED4F97A45358C (groupe_id), PRIMARY KEY(menu_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, groupe_id INT NOT NULL, username VARCHAR(191) NOT NULL, password VARCHAR(64) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', is_active TINYINT(1) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telephone VARCHAR(255) DEFAULT NULL, societe VARCHAR(255) DEFAULT NULL, fonction VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D6497A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93727ACA70 FOREIGN KEY (parent_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_groupe ADD CONSTRAINT FK_D7FED4F9CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_groupe ADD CONSTRAINT FK_D7FED4F97A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id)');
        $this->addSql('DROP TABLE data');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE menu_groupe DROP FOREIGN KEY FK_D7FED4F97A45358C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A45358C');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93727ACA70');
        $this->addSql('ALTER TABLE menu_groupe DROP FOREIGN KEY FK_D7FED4F9CCD7E912');
        $this->addSql('CREATE TABLE data (Country Name VARCHAR(52) DEFAULT \'NULL\' COLLATE utf8_general_ci, Country Code VARCHAR(3) DEFAULT \'NULL\' COLLATE utf8_general_ci, Indicator Name VARCHAR(38) DEFAULT \'NULL\' COLLATE utf8_general_ci, Indicator Code VARCHAR(14) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1960 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1961 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1962 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1963 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1964 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1965 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1966 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1967 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1968 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1969 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1970 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1971 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1972 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1973 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1974 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1975 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1976 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1977 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1978 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1979 VARCHAR(19) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1980 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1981 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1982 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1983 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1984 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1985 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1986 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1987 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1988 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1989 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1990 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1991 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1992 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1993 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1994 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1995 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1996 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1997 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1998 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 1999 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2000 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2001 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2002 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2003 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2004 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2005 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2006 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2007 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2008 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2009 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2010 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2011 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2012 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2013 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2014 VARCHAR(18) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2015 VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2016 VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2017 VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2018 VARCHAR(1) DEFAULT \'NULL\' COLLATE utf8_general_ci, 2019 VARCHAR(10) DEFAULT \'NULL\' COLLATE utf8_general_ci) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_groupe');
        $this->addSql('DROP TABLE user');
    }
}
