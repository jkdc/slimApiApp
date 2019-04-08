<?php

namespace App\Database;


use App\Lib\Elasticsearch\Query\DeleteQuery;
use App\Lib\Elasticsearch\Query\GetQuery;
use App\Lib\Elasticsearch\Query\InsertQuery;
use App\Lib\Elasticsearch\Query\Search\SingleQuerySearch;
use App\Lib\Elasticsearch\Query\UpdateQuery;
use App\Lib\Exception\QueryException;
use App\Model\Author;
use App\Model\Recipe;
use Elasticsearch\ClientBuilder;
use Exception;

class ElasticConnection implements ConnectionInterface
{
    private $client;

    public function connect($connectionParams)
    {
        if (is_null($this->client)) {
            $this->client = ClientBuilder::create()
                ->setHosts($connectionParams)
                ->build();
        }
    }

    public function get($config, $id) {
        try {
            $query = new GetQuery($config, $id);
            $data = $this->client->get($query->query());
            $recipe = $this->createRecipeObject($data);
        } catch (Exception $e) {
            $queryException = new QueryException($e->getMessage(), $e->getCode());
            return $queryException;
        }
        return $recipe;
    }

    public function insert($config, $params) {
        try {
            $query = new InsertQuery($config, $params);
            $data = $this->client->index($query->query());
        } catch (Exception $e) {
            $queryException = new QueryException($e->getMessage(), $e->getCode());
            return $queryException;
        }
        return $data;
    }

    public function update($config, $id, $params) {
        try {
            $query = new UpdateQuery($config, $id, $params);
            $data = $this->client->update($query->query());
        } catch (Exception $e) {
            $queryException = new QueryException($e->getMessage(), $e->getCode());
            return $queryException;
        }
        return $data;
    }

    public function delete($config, $id) {
        try {
            $query = new DeleteQuery($config, $id);
            $data = $this->client->delete($query->query());
        } catch (Exception $e) {
            $queryException = new QueryException($e->getMessage(), $e->getCode());
            return $queryException;
        }
        return $data;
    }

    public function search($config, $filter, $params) {
        try {
            $query = new SingleQuerySearch($config, $filter, $params);
            $data = $this->client->search($query->simpleSearch());
            $recipes = [];
            foreach ($data['hits']['hits'] as $dataRecipe) {
                $recipe = $this->createRecipeObject($dataRecipe);
                $recipes[] = $recipe;
            }
        } catch (Exception $e) {
            $queryException = new QueryException($e->getMessage(), $e->getCode());
            return $queryException;
        }

        return $recipes;
    }

    public function createRecipeObject($params) {
        $data = $params['_source'];

        $author = new Author(
            $data['author']['name'],
            $data['author']['url']
        );

        $recipe = new Recipe(
            $params['_id'],
            $data['title'],
            $data['description'],
            $data['ingredients'],
            $data['directions'],
            $data['prep_time_min'],
            $data['cook_time_min'],
            $data['servings'],
            $data['tags'],
            $author,
            $data['source_url']
        );

        return $recipe;
    }
}