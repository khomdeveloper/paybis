<?php


namespace App\Repository;


use App\Migrations\MigrationList\ExchangeRate;
use App\Migrations\MigrationList\RateSource;
use App\Service\DataBaseServices\DataBaseServiceInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityRepository;

class ExchangeRateRepository extends EntityRepository
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseSerivce)
    {
        $this->dataBaseService = $dataBaseSerivce;
    }

    public function getLastRecord()
    {
        return $this->dataBaseService->executeRawSQL("
            SELECT *
            FROM `exchange_rate`
            WHERE `id` > 0
            ORDER BY `id` DESC
            LIMIT 1
        ",[],[],[
            RateSource::class,
            ExchangeRate::class
        ])->fetch();

    }

    public function getList()
    {
        //здесь добавить вызов из кеша редиса по запросу

        //try to get result from local database
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

        if (empty($result)) {
            //can be empty if bad request
            //or not any records
        }

        return $result;

    }

}