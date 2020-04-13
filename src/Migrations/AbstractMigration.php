<?php


namespace App\Migrations;


use App\Service\DataBaseServices\DataBaseServiceInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractMigration
{

    protected $dataBaseService;

    public function __construct(DataBaseServiceInterface $dataBaseService)
    {
        $this->dataBaseService = $dataBaseService;
    }

    abstract public function up();

    abstract public function dn();



}