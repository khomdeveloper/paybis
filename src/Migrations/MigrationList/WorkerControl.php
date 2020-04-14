<?php


namespace App\Migrations\MigrationList;


class WorkerControl implements MigrationSQLDeterminatorInterface
{

    public function getUpSQL()
    {
       return "
                    CREATE TABLE IF NOT EXISTS `worker_control` (
                      `id` int NOT NULL COMMENT 'Record id' AUTO_INCREMENT PRIMARY KEY,
                      `process` int NULL COMMENT 'Process id',
                      `status` enum ('LIVE','DEAD') NOT NULL DEFAULT 'DEAD'
                    ) ENGINE='InnoDB' COLLATE 'utf8_general_ci';
                ";
    }

    public function getDnSQL()
    {
        // TODO: Implement getDnSQL() method.
    }


    public function getCondition(string $errorMessage)
    {
        if (strpos($errorMessage, 'Base table or view not found') !== false &&
            strpos($errorMessage,'worker_control') !== false) {
            return true;
        } else {
            return false;
        }
    }

}