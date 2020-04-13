<?php


namespace App\Migrations;


class CreateRateSource implements MigrationSQLDeterminatorInterface
{

    public function getUpSQL()
    {
        return "
                    CREATE TABLE IF NOT EXISTS `rate_source` (
                      `id` int NOT NULL COMMENT 'Service id' AUTO_INCREMENT PRIMARY KEY,
                      `url` varchar(255) NOT NULL COMMENT 'Service url',
                      `method` enum ('POST','GET') NULL DEFAULT 'GET',
                      `parameters` varchar(255) NULL COMMENT 'Parameters to request (if necessary)',
                      `frequency` int NULL DEFAULT '1000' COMMENT 'Frequency of request milliseconds',
                      `active` enum ('ACTIVE','NOT ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE' COMMENT 'Active or not'
                    ) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
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