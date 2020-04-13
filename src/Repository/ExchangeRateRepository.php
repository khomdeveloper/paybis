<?php


namespace App\Repository;


use App\Migrations\MigrationList\ExchangeRate;
use App\Migrations\MigrationList\RateSource;
use App\Service\DataBaseServices\DataBaseServiceInterface;
use Doctrine\DBAL\Connection;

class ExchangeRateRepository
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseSerivce)
    {
        $this->dataBaseService = $dataBaseSerivce;
    }

    public function getList()
    {

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
            ],
            [
                RateSource::class,
                ExchangeRate::class
            ]
        );

    }

}