<?php


namespace App\Service\ClientServices;


use App\Entity\ExchangeRate;
use App\Entity\RateSource;
use App\Repository\ExchangeRateRepository;
use App\Service\DataBaseServices\MySQLService;
use App\Service\NetworkServices\RequestService;
use App\Service\NetworkServices\RequestServiceException;
use Doctrine\DBAL\Connection;
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

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function checkActual($actual_time)
    {
        //try to get last record from database
        $exchangeRateRepository = (new ExchangeRateRepository((new MySQLService($this->doctrine))));

        $lastRecord = $exchangeRateRepository->getLastRecord();

        if (empty($lastRecord)){ //TODO: add time criteria

            //TODO: обернуть в транзакцию

            $this->getConnection()->beginTransaction();

            try {

                $rateSource = $this->manager->getRepository(RateSource::class)->findOneBy([
                    'status' => 'READY'
                ]);

                if (empty($rateSource)) {

                    //need to analyze do we have already called service or all services are downed

                    $this->getConnection()->rollBack();

                    return true;
                }

                $rateSource->setStatus('CALLED');

                $this->manager->flush();

                $this->getConnection()->commit();

            } catch (\Throwable $e) {

                $this->getConnection()->rollBack();

                throw $e;
            };

            //calling service for data
            try {

                $response = (new RequestService())->call([
                    CURLOPT_URL => $rateSource->getUrl(),
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_RETURNTRANSFER => 1
                ]);

                if (empty($response)){
                    throw new RequestServiceException('Empty response');
                }

                $data = json_decode($response, true);

                if (!is_array($data)) {
                    throw new RequestServiceException('Wrong response format');
                }

                var_dump($data);

            } catch (\Exception $e) {
                //TODO: handle situation if service downed
            }



        }

        //запрашиваем сервис
        //сбрасываем флаг
        //проставляем дату - сделать секунды с unixtimestamp
        //если сервис упал - добавляем число falldown
        //если этих falldown слишком много выключаем на время сервис
        //используем другой
    }

}