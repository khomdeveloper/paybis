<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Repository\ExchangeRateRepository;
use App\Service\ClientServices\GetDataService;
use App\Service\DataBaseServices\MySQLService;
use App\Service\WorkerControlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Json;


/**
 * Description of ApiController
 *
 * @author valera261104
 */
class ApiController extends AbstractController {

    public function call(Request $request, GetDataService $getDataService)
    {
        try {

            $currency = $request->get('currency');

            $begin = $request->get('begin');

            $end = $request->get('end');

            $mySQLservice = new MySQLService($this->getDoctrine());

            $workerStatus = (new WorkerControlService($mySQLservice))->startWorker();

            var_dump($workerStatus);

            if (empty($currency) && empty($begin) && empty($end)){
                return $this->render('index.html.twig');
            }

            $start = empty($begin) ? (new \DateTime())->modify('-1 day') : new \DateTime($begin);

            $finish = empty($end) ? new \DateTime() : new \DateTime($end);

            if (empty($currency)) {
                $currency = ['EUR','USD','RUB'];
            }

            $list = (new ExchangeRateRepository($mySQLservice))->getList($start, $finish, $currency)->fetchAll();

            return (new JsonResponse([
                'result' => $list
            ]));

        } catch (\Throwable $e) {
            return (new JsonResponse([
                'error' => $e->getMessage()
            ],500));
        }
    }
    
    
}
