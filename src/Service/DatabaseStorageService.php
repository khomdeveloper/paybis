<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use App\Migrations\CreateRateSource;
use App\Service\DataBaseServices\DataBaseServiceInterface;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Description of DatabaseStorageService
 *
 * @author valera261104
 */
class DatabaseStorageService {

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseSerivce)
    {
        $this->dataBaseService = $dataBaseSerivce;
    }

    public function getList($currencies = ['USD','EUR'])
    {
        try {

            $result = $this->dataBaseService->executeRawSQL(
                "
                    SELECT * FROM `exchange_rate`
                    WHERE `currency` in (:currencies)
                    AND `source_id` = :source_id
                ",
                [
                    'currencies' => $currencies,
                    'source_id' => 1
                ],
                [
                    'currencies' => Connection::PARAM_INT_ARRAY,
                    'source_id' => \PDO::PARAM_STR
                ]
            );

            var_dump($result);


        } catch (\Exception $e) {
            $this->createOnError($e);
        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }


    protected function createOnError(\Exception $e)
    {

        $message = $e->getMessage();

        if (strpos($message, 'Base table or view not found') !== false) {

            if (strpos($message,'exchange_rate') !== false) {
                return (new CreateRateSource($this->dataBaseService))->up();
            }

        }

        die($e->getMessage());

        throw $e;

    }

}
