<?php

namespace App\Model;


use JsonSerializable;

/**
 * @OA\Schema(schema="recipe")
 */
class Recipe implements JsonSerializable {
    /**
     * @OA\Property()
     * @var string
     */
    private $id;
    /**
     * @OA\Property()
     * @var string
     */
    private $title;
    /**
     * @OA\Property()
     * @var string
     */
    private $description;
    /**
     * @OA\Property(type="string")
     * @var array
     */
    private $ingredients;
    /**
     * @OA\Property(type="string")
     * @var array
     */
    private $directions;
    /**
     * @OA\Property()
     * @var integer
     */
    private $prepTimeMin;
    /**
     * @OA\Property()
     * @var integer
     */
    private $cookTimeMin;
    /**
     * @OA\Property()
     * @var integer
     */
    private $servings;
    /**
     * @OA\Property(type="string")
     * @var array
     */
    private $tags;
    /**
     * @OA\Property()
     * @var author
     */
    private $author;
    /**
     * @OA\Property()
     * @var string
     */
    private $source_url;

    /**
     * Recipe constructor.
     * @param $id
     * @param $title
     * @param $description
     * @param $ingredients
     * @param $directions
     * @param $prepTimeMin
     * @param $cookTimeMin
     * @param $servings
     * @param $tags
     * @param $author
     * @param $source_url
     */
    public function __construct($id, $title, $description, $ingredients, $directions, $prepTimeMin, $cookTimeMin, $servings, $tags, $author, $source_url)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->ingredients = $ingredients;
        $this->directions = $directions;
        $this->prepTimeMin = $prepTimeMin;
        $this->cookTimeMin = $cookTimeMin;
        $this->servings = $servings;
        $this->tags = $tags;
        $this->author = $author;
        $this->source_url = $source_url;
    }

    /**
     * Get id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set Title
     *
     * @param string $title
     *
     * @return Recipe
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set Description
     *
     * @param string $description
     *
     * @return Recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get ingredients
     *
     * @return mixed
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set Ingredients
     *
     * @param mixed $ingredients
     *
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
        return $this;
    }

    /**
     * Get directions
     *
     * @return mixed
     */
    public function getDirections()
    {
        return $this->directions;
    }

    /**
     * Set Directions
     *
     * @param $directions
     *
     * @return Recipe
     */
    public function setDirections($directions)
    {
        $this->directions = $directions;
        return $this;
    }

    /**
     * Get prepTimeMin
     *
     * @return integer
     */
    public function getPrepTimeMin()
    {
        return $this->prepTimeMin;
    }

    /**
     * Set PrepTimeMin
     *
     * @param integer $prepTimeMin
     *
     * @return Recipe
     */
    public function setPrepTimeMin($prepTimeMin)
    {
        $this->prepTimeMin = $prepTimeMin;
        return $this;
    }

    /**
     * Get cookTimeMin
     *
     * @return mixed
     */
    public function getCookTimeMin()
    {
        return $this->cookTimeMin;
    }

    /**
     * Set CookTimeMin
     *
     * @param integer $cookTimeMin
     *
     * @return Recipe
     */
    public function setCookTimeMin($cookTimeMin)
    {
        $this->cookTimeMin = $cookTimeMin;
        return $this;
    }


    /**
     * Get servings
     *
     * @return integer
     */
    public function getServings()
    {
        return $this->servings;
    }

    /**
     * Set Servings
     *
     * @param integer $servings
     *
     * @return Recipe
     */
    public function setServings($servings)
    {
        $this->servings = $servings;
        return $this;
    }

    /**
     * Get tags
     *
     * @return mixed
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set Tags
     *
     * @param mixed $tags
     *
     * @return Recipe
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
        return $this;
    }

    /**
     * Get author
     *
     * @return Author
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set Author
     *
     * @param Author $author
     *
     * @return Recipe
     */
    public function setAuthor(Author $author)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * Get source_url
     *
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->source_url;
    }

    /**
     * Set SourceUrl
     *
     * @param string $source_url
     *
     * @return Recipe
     */
    public function setSourceUrl($source_url)
    {
        $this->source_url = $source_url;
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize()
    {
        $recipe = [
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'directions' => $this->directions,
            'prep_time_min' => $this->prepTimeMin,
            'cook_time_min' => $this->cookTimeMin,
            'servings' => $this->servings,
            'tags' => $this->tags,
            'author' => $this->author,
            'source_url' => $this->source_url
        ];

        if (!is_null($this->id)) {
            $recipe['id'] = $this->id;
        }

        return $recipe;
    }
}