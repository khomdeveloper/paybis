<?php


namespace App\Migrations\MigrationList;


interface MigrationSQLDeterminatorInterface
{
    public function getUpSQL();

    public function getDnSQL();

    public function getCondition(string $errorMessage);
}