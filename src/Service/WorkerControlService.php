<?php


namespace App\Service;


use App\Migrations\MigrationList\WorkerControl;
use App\Service\DataBaseServices\DataBaseServiceInterface;

class WorkerControlService
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseSerivce)
    {
        $this->dataBaseService = $dataBaseSerivce;
    }

    public function checkWorker()
    {
        $result = $this->dataBaseService->executeRawSQL("
            SELECT count(*) as `count` FROM `worker_control`
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

            return true;

        } else {
            return false;
        }
    }





}