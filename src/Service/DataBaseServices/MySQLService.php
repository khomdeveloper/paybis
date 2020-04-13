<?php


namespace App\Service\DataBaseServices;


use App\Migrations\AutoMigration;
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

    public function executeRawSQL(string $sql, array $values = [], array $types = [], $autoMigration = null)
    {
        try {

            return $this->connection
                ->executeQuery($sql, $values, $types);

        } catch (\Exception $e) {
            if (empty($autoMigration)){
                throw $e;
            } else {
                if (is_string($autoMigration)) {
                    (new AutoMigration($this, $autoMigration))->condition($e)->up();
                } elseif (is_array($autoMigration)){
                    foreach ($autoMigration as $migration){
                        die($migration);
                        (new AutoMigration($this, $migration))->condition($e)->up();
                    }
                }
                $this->executeRawSQL($sql, $values, $types); //run recursively without $autoMigration variable so we try to migrate once
            }
        }
    }

}