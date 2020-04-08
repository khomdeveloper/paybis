<?php

namespace App\Service;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EntryService
 *
 * @author valera261104
 */
class EntryService {
    
    protected $connection;
   
    public function __constructor($entityManager)
    {
        $this->connection = $entityManager->getConnection();  
    }
    
    public function getList($order = [], $start = [], $limit = []) {
        
        $sql = "
            SELECT * FROM `entry`
            LEFT JOIN `user` on `entry`.`author_id` = `user`.`id`
            ORDER BY `date`
            LIMIT 3
            ";
        
        $statement = $this->connection->prepare($sql);
        return $statement->execute();
        
    }
    
}
