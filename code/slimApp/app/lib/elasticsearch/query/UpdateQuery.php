<?php


namespace App\Lib\Elasticsearch\Query;


class UpdateQuery implements QueryInterface
{
    private $index;
    private $type;
    private $id;
    private $params;

    /**
     * UpdateQuery constructor.
     * @param $schema
     * @param $id
     * @param $params
     */
    public function __construct($schema, $id, $params)
    {
        $this->index = $schema['index'];
        $this->type = $schema['type'];
        $this->id = $id;
        $this->params = $params;
    }


    public function query()
    {
        $query = [
            'index' => $this->index,
            'type' => $this->type,
            'id' => $this->id,
            'body' => [
                'doc' => $this->params
            ]
        ];

        return $query;
    }
}