<?php


namespace App\Service\DataBaseServices;


use Doctrine\Persistence\ManagerRegistry;

interface DataBaseServiceInterface
{

    public function executeRawSQL(string $sql, array $values, array $types);

}