<?php


namespace App\Database;


class Database
{
    private $dbConnection;

    public function __construct(ConnectionInterface $dbConnection) {
        $this->dbConnection = $dbConnection;
    }

    public function getConnection($databaseParams) {
        $this->dbConnection->connect($databaseParams);

        return $this->dbConnection;
    }
}