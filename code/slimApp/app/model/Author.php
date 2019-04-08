<?php

namespace App\Model;


use JsonSerializable;

class Author implements JsonSerializable{
    private $name;
    private $url;

    /**
     * Author constructor.
     * @param $name
     * @param $url
     */
    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     *
     * @return Author
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set Url
     *
     * @param string $url
     *
     * @return Author
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }


    /**
     * Specify data which should be serialized to JSON
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'url' => $this->url
        ];
    }
}