<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration to create database table.
 */
final class Version20221110064334 extends AbstractMigration
{
    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function up(Schema $schema): void
    {
        $this->addSql("
            CREATE TABLE `temperature_query` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,   
                `json_data` json DEFAULT NULL,
                `ip_address` varchar(50) DEFAULT NULL,
                `mkt` decimal(10,2) DEFAULT '0.00',
                `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                 PRIMARY KEY (`id`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    /**
     * @param Schema $schema
     *
     * @return void
     */
    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE IF EXISTS `temperature_query`;");
    }
}
