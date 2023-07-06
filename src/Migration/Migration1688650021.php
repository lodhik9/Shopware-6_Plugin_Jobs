<?php declare(strict_types=1);

namespace Swag\JobExampleSecond\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1688650021 extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1688650021;
    }

    public function update(Connection $connection): void
    {
         $connection->exec("
        CREATE TABLE IF NOT EXISTS `swag_job_entity` (
            `id` BINARY(16) NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `description` VARCHAR(255) NOT NULL,
            `image_id` BINARY(16) NULL,
            `age` INT NOT NULL,
            `active` TINYINT(1) NOT NULL,
            PRIMARY KEY (`id`),
            CONSTRAINT `fk.swag_job_entity.media_id` FOREIGN KEY (`image_id`) REFERENCES `media` (`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    }

    public function updateDestructive(Connection $connection): void
    {
        // implement update destructive
    }
}
