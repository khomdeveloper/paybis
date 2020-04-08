<?php

namespace App\Controller;

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
        return new Response('wtf');
        
        //return $this->render('templates/index.html.twig');
    }
    
}
