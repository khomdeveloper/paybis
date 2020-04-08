<?php

namespace App\Controller;

use App\Entity\Entry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\EntryService;

/**
 * Description of DefaultController
 *
 * @author valera261104
 */
class PageController extends AbstractController {
    
    public function index()
    {
        
        try {
            
        /*$this
                ->getDoctrine()
                ->getRepository(Entry::class)
                ->findBy([],[
                    'date' => 'DESC'
                ], 3);
        
        $list = [];
        foreach ($records as $record) {
            //$list['name'] 
        }*/
            
        $data = (new EntryService($this->getEntityManager()))->getList(); 
        
        var_dumop($data);
           
        return $this->render('index.html.twig', ['list' => $list]);
       
        } catch (\Throwable $e) {
            
            die($e->getMessage());
            
        }
        
    }
    
}
