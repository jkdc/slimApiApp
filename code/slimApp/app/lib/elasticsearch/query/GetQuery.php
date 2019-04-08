<?php


namespace App\Lib\Elasticsearch\Query;


class GetQuery implements QueryInterface
{
    private $index;
    private $type;
    private $id;

    /**
     * GetQuery constructor.
     * @param $schema
     * @param $id
     */
    public function __construct($schema, $id)
    {
        $this->index = $schema['index'];
        $this->type = $schema['type'];
        $this->id = $id;
    }


    public function query()
    {
        $query = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $this->id
        ];

        return $query;
    }
}