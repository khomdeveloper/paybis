<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

/**
 * Description of DatabaseStorageService
 *
 * @author valera261104
 */
class DatabaseStorageService {

    protected $doctrine;

    public function __construct($doctrine)
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

            $stmt = $conn->executeQuery($sql, $values, $types);
            $result = $stmt->fetchAll();

            var_dump($result);
        } catch (\Exception $e) {

            die($e->getMessage());
        }
    }

}
