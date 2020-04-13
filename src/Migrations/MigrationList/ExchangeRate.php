<?php


namespace App\Migrations\MigrationList;


class ExchangeRate implements MigrationSQLDeterminatorInterface
{

    public function getUpSQL()
    {
        return "
                    CREATE TABLE `exchange_rate` (
                      `id` int NOT NULL COMMENT 'Self incremental id' AUTO_INCREMENT PRIMARY KEY,
                      `source_id` int(11) NOT NULL COMMENT 'Data source id',
                      `currency` varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'Currency',
                      `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Insert Date',
                      `rate` float NOT NULL COMMENT 'Exchange rate',
                      FOREIGN KEY (`source_id`) REFERENCES `rate_source` (`id`) ON DELETE RESTRICT
                    ) COMMENT='Record auto increment id' ENGINE='InnoDB' COLLATE 'utf8_general_ci';
                ";
    }

    public function getDnSQL()
    {

    }

    public function getCondition(string $errorMessage)
    {
        if (strpos($errorMessage, 'Base table or view not found') !== false &&
            strpos($errorMessage,'exchange_rate') !== false) {
            return true;
        } else {
            return false;
        }
    }

}