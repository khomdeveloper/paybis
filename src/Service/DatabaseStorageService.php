<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Description of DatabaseStorageService
 *
 * @author valera261104
 */
class DatabaseStorageService {

    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getList($currencies = ['USD','EUR'])
    {
        try {

            $sql = "
                SELECT * FROM `exchange_rate`
                WHERE `currency` in (:currencies)
                AND `source_id` = :source_id
            ";

            $values = [
                'currencies' => $currencies,
                'source_id' => 1
            ];

            $types = [
                'currencies' => Connection::PARAM_INT_ARRAY,
                'source_id' => \PDO::PARAM_STR
            ];

            $stmt = $this
                ->doctrine
                ->getManager()
                ->getConnection()
                ->executeQuery($sql, $values, $types);

            $result = $stmt->fetchAll();

            var_dump($result);
        } catch (\Exception $e) {

            die($e->getMessage());
        }
    }


    protected function createOnError($message)
    {
        if (strpos($message, 'Base table or view not found') !== false) {

            if (strpos($message,'exchange_rate') !== false) {

                $sql = "
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

        }

    }

}
