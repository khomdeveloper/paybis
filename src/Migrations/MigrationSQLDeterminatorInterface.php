<?php


namespace App\Migrations;


interface MigrationSQLDeterminatorInterface
{
    public function getUpSQL();

    public function getDnSQL();

    public function getCondition(string $errorMessage);
}