<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Entry
 *
 * @author valera261104
 * 
 * @ORM\Entity
 * 
 * @ORM\Table(name="user")
 * 
 */
class User {
    
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     *
     * @ORM\Column(type="string")
     */
    public $login;
    
    /**
     *
     * @ORM\Column(type="string")
     */
    public $pass;
    
    
}
