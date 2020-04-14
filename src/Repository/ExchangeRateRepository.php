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

    public function getList(\DateTime $start, \DateTime $finish , $currency = ['EUR','USD','RUB'])
    {
        if (is_string($currency)){
            $currency = [$currency];
        }

        $now = time();

        $end = min($now, $finish->getTimestamp());
        $begin = min($end, $start->getTimestamp());

        var_dump($begin);

        var_dump($end);

        var_dump($currency);

        //TODO: add here redis cache

        //try to get result from local database
        $result = $this->dataBaseService->executeRawSQL(
            "
                    SELECT * FROM `exchange_rate`
                    WHERE `currency` in (:currency)
                    AND `date` < :end 
                    AND `date` > :begin
                ",
            [
                'currency' => $currency,
                'end' => $end,
                'begin' => $begin,
            ],
            [
                'currency' => Connection::PARAM_STR_ARRAY,
                'end' => \PDO::PARAM_STR,
                'begin' => \PDO::PARAM_STR,
            ],
            [
                RateSource::class,
                ExchangeRate::class
            ]
        );

        return $result;

    }

}