<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service;

/**
 * Description of AuthService
 *
 * @author valera261104
 */
class AuthService {
    
    protected $entityManager;
   
    public function __construct($entityManager)
    { 
        $this->entityManager = $entityManager;  
    }
    
    public function check($login, $pass){
        
        
        
    }
    
}
