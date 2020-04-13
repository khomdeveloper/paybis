<?php


namespace App\Service\DataBaseServices;


use Doctrine\Persistence\ManagerRegistry;

class MySQLService implements DataBaseServiceInterface
{

    protected $doctrine;
    protected $manager;
    protected $connection;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->manager = $this->doctrine->getManager();
        $this->connection = $this->manager->getConnection();
    }

    public function executeRawSQL(string $sql, array $values = [], array $types = [])
    {
        $stmt = $this->connection
            ->executeQuery($sql, $values, $types);

        var_dump($stmt);


        die('stop');

        return $stmt;
    }

}