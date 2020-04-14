<?php


namespace App\Service\ClientServices;


use App\Entity\ExchangeRate;
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

    public function checkActual()
    {
        //try to get last record from database
        

        //пытаемся получить последнюю запись из базы
        //если ее вообще нет или ее дата обновления протухла
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