<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of ApiController
 *
 * @author valera261104
 */
class ApiController {
    
    public function call(Request $request)
    {
     
        $dataBaseService = new DatabaseStorageService($this->doctrine);
        
        $dataBaseServiсe->getList();
        
    }
    
    
}
