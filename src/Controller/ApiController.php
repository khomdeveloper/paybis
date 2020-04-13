<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Service\DatabaseStorageService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of ApiController
 *
 * @author valera261104
 */
class ApiController extends AbstractController {
    
    public function call(Request $request)
    {
        try {

            $dataBaseService = new DatabaseStorageService($this->getDoctrine());

            $dataBaseService->getList();

        } catch (\Throwable $e) {
            die($e->getMessage());
        }
    }
    
    
}
