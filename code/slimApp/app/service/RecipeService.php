<?php

namespace App\Service;


use App\Database\Database;
use App\Database\ElasticConnection;


class RecipeService
{
    protected $db;

    public function __construct($databaseParams)
    {
        $database = new Database(new ElasticConnection);
        $this->db = $database->getConnection($databaseParams);
    }

    public function getRecipe($config, $id)
    {
        $queryData = $this->db->get($config, $id);

        return $queryData;
    }

    public function insertRecipe($config, $params)
    {
        $queryData = $this->db->insert($config, $params);

        return $queryData;
    }

    public function updateRecipe($config, $id, $params)
    {
        $queryData = $this->db->update($config, $id, $params);

        return $queryData;
    }

    public function deleteRecipe($config, $id)
    {
        $queryData = $this->db->delete($config, $id);

        return $queryData;
    }

    public function searchRecipe($config, $filter, $params)
    {
        $queryData = $this->db->search($config, $filter, $params);

        return $queryData;
    }

}