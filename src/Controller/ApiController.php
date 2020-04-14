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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * Description of ApiController
 *
 * @author valera261104
 */
class ApiController extends AbstractController {

    public function call(Request $request, GetDataService $getDataService)
    {
        try {

            $mySQLservice = new MySQLService($this->getDoctrine());

            //$list = (new ExchangeRateRepository($mySQLservice))->getList();

            //$list = (new ExchangeRateRepository($mySQLservice))->getLastRecord();

            //var_dump($list);

            //$getDataService = $this->container->get(GetDataService::class);

            $getDataService->checkActual($this->getParameter('delay_between_calls'));

            return (new JsonResponse([
                'status' => 'success'
            ]));

        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
    
    
}
