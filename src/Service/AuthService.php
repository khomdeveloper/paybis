<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

use App\Entity\User;


/**
 * Description of AuthService
 *
 * @author valera261104
 */
class AuthService {
    
    protected $doctrine;
   
    public function __construct($doctrine, SessionInterface $session)
    { 
        $this->doctrine = $doctrine;  
    }
    
    public function check($login, $pass){
        
        $result = $this->doctrine
                ->getRepository(User::class)
                ->findBy([
                   'password' => sha1($pass),
                    'email' => $login
                ],[],1);
        
       var_dump($result);
           
    }
    
}
