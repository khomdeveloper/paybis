<?php


namespace App\Service\ClientServices;


use App\Entity\ExchangeRate;
use App\Entity\RateSource;
use App\Repository\ExchangeRateRepository;
use App\Service\DataBaseServices\MySQLService;
use Doctrine\Persistence\ManagerRegistry;

class GetDataService
{

    protected $doctrine;
    protected $manager;
    protected $connection;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->manager = $this->doctrine->getManager();
        $this->connection = $this->manager->getConnection();
    }

    public function checkActual($actual_time)
    {
        //try to get last record from database
        $exchangeRateRepository = (new ExchangeRateRepository((new MySQLService($this->doctrine))));

        $lastRecord = $exchangeRateRepository->getLastRecord();

        if (empty($lastRecord)){ //TODO: add time criteria
            $dataSource = $this->manager->getRepository(RateSource::class)->findOneBy([
               'status' => 'READY'
            ])->fetch();

            var_dump($dataSource);

            die($actual_time);
        }

        //если флаг called уже стоит ничего не делаем
        //ищем доступный сервис
        //запрашиваем сервис
        //сбрасываем флаг
        //проставляем дату - сделать секунды с unixtimestamp
        //если сервис упал - добавляем число falldown
        //если этих falldown слишком много выключаем на время сервис
        //используем другой
    }

}