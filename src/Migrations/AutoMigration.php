<?php


namespace App\Migrations;


use App\Service\DataBaseServices\DataBaseServiceInterface;

class AutoMigration extends AbstractMigration
{

    protected $migrationName;

    public function __construct(DataBaseServiceInterface $dataBaseService, string $migrationName)
    {
        $this->migrationName = $migrationName;

        parent::__construct($dataBaseService);
    }

    public function up()
    {
        if (!class_exists($this->migrationName)) {
            throw new \Exception("Class {$this->migrationName} not exists");
        }

        $upSQL = (new $this->migrationName())->getUpSQL();

        if (is_array($upSQL)) {

            foreach ($upSQL as $sql) {
               $stmt = $this->dataBaseService->executeRawSQL(
                   $sql,
                   [],
                   [],
                   false
               );
            }

            return $stmt;

        } else {
            return $this->dataBaseService->executeRawSQL(
                $upSQL,
                [],
                [],
                false
            );
        }
    }

    public function dn()
    {

    }

    public function condition(\Exception $e) {

        if (class_exists($this->migrationName)) {
            $migration = new $this->migrationName();
            if ($migration->getCondition($e->getMessage())) {
                return $this;
            }
        }

        throw $e;
    }

}