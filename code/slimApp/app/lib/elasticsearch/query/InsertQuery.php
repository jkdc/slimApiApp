<?php


namespace App\Lib\Elasticsearch\Query;


use App\Model\Recipe;

class InsertQuery implements QueryInterface
{
    private $index;
    private $type;
    private $params;

    /**
     * InsertQuery constructor.
     * @param $schema
     * @param $params
     */
    public function __construct($schema, $params)
    {
        $this->index = $schema['index'];
        $this->type = $schema['type'];
        $this->params = $params;
    }


    public function query()
    {
        $recipe = new Recipe(
             null,
            array_key_exists('title', $this->params) ? $this->params['title'] : null,
            array_key_exists('description', $this->params) ? $this->params['description'] : null,
            array_key_exists('ingredients', $this->params) ? $this->params['ingredients'] : null,
            array_key_exists('directions', $this->params) ? $this->params['directions'] : null,
            array_key_exists('prep_time_min', $this->params) ? $this->params['prep_time_min'] : null,
            array_key_exists('cook_time_min', $this->params) ? $this->params['cook_time_min'] : null,
            array_key_exists('servings', $this->params) ? $this->params['servings'] : null,
            array_key_exists('tags', $this->params) ? $this->params['tags'] : null,
            array_key_exists('author', $this->params) ? $this->params['author'] : null,
            array_key_exists('source_url', $this->params) ? $this->params['source_url'] : null
        );

        $query = [
            'index' => $this->index,
            'type' => $this->type,
            'body' => $recipe
        ];

        if (array_key_exists('id', $this->params)) {
            $query['id'] = $this->params['id'];
        }

        return $query;
    }
}