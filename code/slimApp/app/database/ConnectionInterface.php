<?php

namespace App\Database;

interface ConnectionInterface
{
    public function connect($connectionParams);

    public function get($config, $id);

    public function insert($config, $params);

    public function update($config, $id, $params);

    public function delete($config, $id);

    public function search($config, $filter, $params);

}