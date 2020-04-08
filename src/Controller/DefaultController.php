<?php

namespace App\Controller;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of DefaultController
 *
 * @author valera261104
 */
class DefaultController {
    
    public function index()
    {
      return new Response('OK');   
    }
    
}
