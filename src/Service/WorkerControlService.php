<?php


namespace App\Service;


use App\Migrations\MigrationList\WorkerControl;
use App\Service\DataBaseServices\DataBaseServiceInterface;

class WorkerControlService
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseService)
    {
        $this->dataBaseService = $dataBaseService;
    }

    public function checkWorker()
    {
        $result = $this->dataBaseService->executeRawSQL("
            SELECT count(*) as `count` 
            FROM `worker_control`
        ",[],[],[
            WorkerControl::class
        ])->fetch();

        if (!empty($result) && $result['count'] * 1 > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function startWorker()
    {
        if (!$this->checkWorker()) {

            $this->dataBaseService->executeRawSQL("
            INSERT INTO `worker_control` (`process`,`status`)
            VALUES (1, 'LIVE')
        ", [], [], [
                WorkerControl::class
            ]);

            /*
            $cmd = "php bin/console app:updateExchangeRate --loop=20 > /dev/null 2>/dev/null &";
            shell_exec($cmd);*/

            return true;

        } else {
            return false;
        }
    }


    public function stopWorker()
    {

        $result = $this->dataBaseService->executeRawSQL("
            SELECT `id` as `count` 
            FROM `worker_control`
        ",[],[],[
            WorkerControl::class
        ])->fetch();


        if (!empty($result) && isset($result['id'])) {

            $this->dataBaseService->executeRawSQL("
               DELETE FROM `worker_control`
               WHERE `id` = :id   
            ", [
                'id' => $result['id']
            ], [
                'id' => \PDO::PARAM_STR
            ]);

        }

    }


    public function needToStop()
    {

        $result = $this->dataBaseService->executeRawSQL("
            SELECT `status` FROM `worker_control`
        ",[],[],[
            WorkerControl::class
        ])->fetch();

        if (!empty($result) && $result['status'] == 'DEAD') {
            return true;
        } else {
            return false;
        }

    }




}