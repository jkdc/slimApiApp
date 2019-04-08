<?php


namespace App\Lib\Elasticsearch\Query\Search;


class SingleQuerySearch implements QuerySearchInterface
{
    private $index;
    private $type;
    private $filter;
    private $params;

    /**
     * SingleQuerySearch constructor.
     * @param $schema
     * @param $filter
     * @param $params
     */
    public function __construct($schema, $filter, $params)
    {
        $this->index = $schema['index'];
        $this->type = $schema['type'];
        $this->filter = $filter;
        $this->params = $params;
    }

    public function simpleSearch()
    {
        return [
            'index' => $this->index,
            'type' => $this->type,
            'body' => [
                'query' => [
                    $this->filter => (sizeof($this->params) > 0) ? $this->params : json_decode ("{}")
                ]
            ]
        ];
    }

}