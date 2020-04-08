<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Entry
 *
 * @author valera261104
 * 
 * @ORM\Entity
 * 
 * @ORM\Table(name="entry")
 * 
 */
class Entry {
    //put your code here
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
     /**
     * @ORM\Column(type="string", length=100)
     */
    public $title;
    
  
    
}
