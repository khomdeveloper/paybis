<?php


namespace App\Migrations\MigrationList;


class RateSource implements MigrationSQLDeterminatorInterface
{

    public function getUpSQL()
    {
        return ["
                    CREATE TABLE IF NOT EXISTS `rate_source` (
                      `id` int NOT NULL COMMENT 'Service id' AUTO_INCREMENT PRIMARY KEY,
                      `url` varchar(255) NOT NULL COMMENT 'Service url',
                      `name` varchar (255) NOT NULL COMMENT 'Service name'
                      `method` enum ('POST','GET') NULL DEFAULT 'GET',
                      `parameters` varchar(255) NULL COMMENT 'Parameters to request (if necessary)',
                      `frequency` float NULL DEFAULT 1.0 COMMENT 'Frequency of request in seconds',
                      `status` enum ('READY','CALLED','DOWNED','DEPRECATED') NOT NULL DEFAULT 'READY' COMMENT 'Active or not',
                      `down_counter` int NOT NULL default 0 COMMENT 'Source down counter'
                    ) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
                ","
                    INSERT IGNORE INTO `rate_source`(`url`, `name`)
                    VALUES ('https://blockchain.info/ticker', 'blockchain.info')
                "];
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