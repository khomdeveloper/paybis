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
            SELECT `status` FROM `worker_control`
        ",[],[],[
            WorkerControl::class
        ])->fetchOne();

        var_dump($result);
    }

    public function startWorker()
    {
        $this->dataBaseService->executeRawSQL("
            INSERT INTO `worker_control` (`process`,`status`)
            VALUES (1, 'LIVE')
        ",[],[],[
            WorkerControl::class
        ]);
    }





}