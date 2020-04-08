<?php

namespace App\Controller;

use App\Entity\Entry;

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
            
        $list = $this
                ->getDoctrine()
                ->getRepository(Entry::class)
                ->findBy([],[
                    'id' => 'DESC'
                ], 3);
           
        return $this->render('index.html.twig', ['list' => $list]);
       
        } catch (\Throwable $e) {
            
            die($e->getMessage());
            
        }
        
    }
    
}
