<?php


namespace App\Service\ClientServices;


use App\Entity\RateSource;
use App\Service\DataBaseServices\DataBaseServiceInterface;
use App\Service\NetworkServices\RequestServiceException;
use Doctrine\DBAL\Connection;

class RateSourceResponseParser
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseSerivce)
    {
        $this->dataBaseService = $dataBaseSerivce;
    }


    public function parseAndSave(RateSource $source, $response)
    {
        if ($source->getName() == 'blockchain.info') {

            $data = json_decode($response, true);

            if (!is_array($data) || empty($data)) {
                throw new RequestServiceException('Wrong response format');
            }

            $time = microtime(true);

            foreach (['USD','EUR','RUB'] as $currency) {
                $value[$currency] = [
                    $source->id,
                    $currency,
                    $time,
                    $data[$currency]['last']
                ];
            }

            var_dump($value);

            $sql = "
                    INSERT INTO `exchange_rate` 
                    (`source_id`,`currency`,`date`,`rate`)
                    VALUES
                    (:USD),
                    (:RUB),
                    (:EUR)
                   ";

            $this->dataBaseService->executeRawSQL($sql, [
                'USD' => $value['USD'],
                'RUB' => $value['RUB'],
                'EUR' => $value['EUR']
            ] , [
                'USD' => Connection::PARAM_INT_ARRAY,
                'RUB' => Connection::PARAM_INT_ARRAY,
                'EUR' => Connection::PARAM_INT_ARRAY
            ]);

            return true;
        }

        throw new \Exception("Undescribed algotithm of parsing response from {$sourceName}");
    }

}