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
        try {
        
        $login = filter_var(substr(trim($request->request->get('login')),0,10), FILTER_VALIDATE_EMAIL);
        $pass = substr(trim($request->request->get('pass')),0,10);
        if (empty($login) || empty($pass)){
            throw new \Exception('Login or pass not valid');
        }
        
        var_dump($login);
        
        } catch (\Exception $e) {
          die($e->getMessage());   
        }
    }
    
}
