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

    public function checkActual($delayBetweenCalls)
    {
        //try to get last record from database
        $exchangeRateRepository = (new ExchangeRateRepository((new MySQLService($this->doctrine))));

        $lastRecord = $exchangeRateRepository->getLastRecord();

        if (!empty($lastRecord)) {
            $expectedTimeToCall = $lastRecord['date'] + $delayBetweenCalls;
        }

        if (empty($lastRecord) || microtime(true) > $expectedTimeToCall){

            $this->getConnection()->beginTransaction();

            try {

                $rateSource = $this->manager->getRepository(RateSource::class)->findOneBy([
                    'status' => 'READY'
                ]);

                if (empty($rateSource)) {
                    //need to analyze do we have already called service or all services are downed
                    $this->getConnection()->rollBack();

                    $calledSource = $this->manager->getRepository(RateSource::class)->findOneBy([
                        'status' => 'CALLED'
                    ]);

                    if (empty($calledSource)) {
                        throw new \Exception('No services available');
                    }

                    return true;
                }

                //lockRateSource
                $rateSource->setStatus('CALLED');
                $this->manager->flush();
                $this->getConnection()->commit();

            } catch (\Throwable $e) {
                $this->getConnection()->rollBack();

                throw $e;
            };


            try {

                //TODO: analyze data in mysql source description

                //calling service for data
                $response = (new RequestService())->call([
                    CURLOPT_URL => $rateSource->getUrl(),
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_RETURNTRANSFER => 1,
                ]);

                if (empty($response)){
                    throw new RequestServiceException('Empty response');
                }

                $this->getConnection()->beginTransaction();
                try {
                    $databaseService = new MySQLService($this->doctrine);

                    (new RateSourceResponseParser($databaseService))
                        ->parseAndSave($rateSource, $response);

                    //unlock rateSource
                    $rateSource->setStatus('READY');
                    $this->manager->flush();

                    $this->getConnection()->commit();

                } catch (\Throwable $e) {
                    $this->getConnection()->rollBack();
                    throw $e;
                }

                return true;

            } catch (\Exception $e) {
                //TODO: handle situation if service downed

                //unlock rateSource
                $rateSource->setStatus('READY');
                $this->manager->flush();


                throw $e;
            }


        }

        //если сервис упал - добавляем число falldown
        //если этих falldown слишком много выключаем на время сервис
        //используем другой
    }

}