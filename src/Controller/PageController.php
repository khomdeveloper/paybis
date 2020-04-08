<?php

namespace App\Controller;

use App\Entity;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Description of DefaultController
 *
 * @author valera261104
 */
class PageController extends AbstractController {
    
    public function index()
    {
        
        try {
            
        $product = $this
                ->getDoctrine()
                ->getRepository(Entry::class)
                ->findAll();
           
        var_dump($product); 
       
        return $this->render('index.html.twig');
        
        } catch (\Throwable $e) {
            
            die($e->getMessage());
            
        }
        
    }
    
}
