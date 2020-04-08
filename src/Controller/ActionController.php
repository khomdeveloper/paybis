<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of ActionController
 *
 * @author valera261104
 */
class ActionController extends AbstractController{
   
    public function login(Request $request)
    {
        var_dump($request);
    }
    
}
