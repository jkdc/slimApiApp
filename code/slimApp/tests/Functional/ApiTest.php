<?php

namespace Tests\Functional;

use App\Model\Author;
use App\Model\Recipe;

class ApiTest extends BaseTestCase
{
    protected $apiPath = '/api/v1';
    protected $urlParams = '/recipe';
    protected $urlSerchParams = '/recipe/search';
    protected $id = 'TestId';
    protected $idFail = 'TestIdFail';

    /**
     * Test POST petition to create new data
     */
    public function testPostNewData()
    {
        $recipe = $this->getRecipe($this->id);
        $urlPath = $this->apiPath . $this->urlParams;
        $response = $this->runApp('POST', $urlPath, $recipe->jsonSerialize());
        $dataResponse = json_decode($response->getBody(), true);

        $this->assertContains('_id', (string)$response->getBody());
        $this->assertEquals($this->id, $dataResponse['_id']);
        $this->assertEquals('created', $dataResponse['result']);
    }

    /**
     * Test GET petition that return data found
     */
    public function testGetDataFound()
    {
        $recipe = $this->getRecipe($this->id);
        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->id;
        $response = $this->runApp('GET', $urlPath);
        $dataResponse = json_decode($response->getBody(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertContains('title', (string)$response->getBody());
        $this->assertContains('description', (string)$response->getBody());
        $this->assertContains('ingredients', (string)$response->getBody());
        $this->assertContains('directions', (string)$response->getBody());
        $this->assertContains('prep_time_min', (string)$response->getBody());
        $this->assertContains('cook_time_min', (string)$response->getBody());
        $this->assertContains('servings', (string)$response->getBody());
        $this->assertContains('tags', (string)$response->getBody());
        $this->assertContains('author', (string)$response->getBody());
        $this->assertContains('source_url', (string)$response->getBody());

        $this->assertNotContains('message', (string)$response->getBody());
        $this->assertNotContains('error', (string)$response->getBody());

        $this->assertEquals($recipe->getId(), $dataResponse['id']);
        $this->assertEquals($recipe->getTitle(), $dataResponse['title']);
        $this->assertEquals($recipe->getDescription(), $dataResponse['description']);
        $this->assertEquals($recipe->getIngredients(), $dataResponse['ingredients']);
        $this->assertEquals($recipe->getDirections(), $dataResponse['directions']);
        $this->assertEquals($recipe->getPrepTimeMin(), $dataResponse['prep_time_min']);
        $this->assertEquals($recipe->getCookTimeMin(), $dataResponse['cook_time_min']);
        $this->assertEquals($recipe->getServings(), $dataResponse['servings']);
        $this->assertEquals($recipe->getTags(), $dataResponse['tags']);
        $this->assertEquals($recipe->getAuthor()->jsonSerialize(), $dataResponse['author']);
        $this->assertEquals($recipe->getSourceUrl(), $dataResponse['source_url']);


    }

    /**
     * Test GET petition that return data not found
     */
    public function testGetDataNotFound()
    {
        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->idFail;
        $response = $this->runApp('GET', $urlPath);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals(200, $response->getStatusCode());

        $this->assertContains('message', (string)$response->getBody());
        $this->assertContains('found', (string)$response->getBody());
        $this->assertContains('false', (string)$response->getBody());

        $this->assertNotContains('title', (string)$response->getBody());
        $this->assertNotContains('description', (string)$response->getBody());
        $this->assertNotContains('ingredients', (string)$response->getBody());
        $this->assertNotContains('directions', (string)$response->getBody());
        $this->assertNotContains('servings', (string)$response->getBody());
        $this->assertNotContains('tags', (string)$response->getBody());
        $this->assertNotContains('author', (string)$response->getBody());
        $this->assertNotContains('source_url', (string)$response->getBody());
    }


    /**
     * Test PUT petition that update data
     */
    public function testUpdateData()
    {
        //$recipe = $this->getRecipe($this->id);
        $recipeUpdate = $this->getRecipeUpdate($this->id);

        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->id;
        $response = $this->runApp('PUT', $urlPath, $recipeUpdate->jsonSerialize());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertContains('_index', (string)$response->getBody());
        $this->assertContains('_type', (string)$response->getBody());
        $this->assertContains('_id', (string)$response->getBody());
        $this->assertContains('_version', (string)$response->getBody());
        $this->assertContains('result', (string)$response->getBody());
        $this->assertContains('_shards', (string)$response->getBody());
        $this->assertContains('updated', (string)$response->getBody());
        $this->assertContains('successful', (string)$response->getBody());

        $response = $this->runApp('GET', $urlPath);
        $dataResponse = json_decode($response->getBody(), true);

        $this->assertEquals($recipeUpdate->getId(), $dataResponse['id']);
        $this->assertEquals($recipeUpdate->getTitle(), $dataResponse['title']);
        $this->assertEquals($recipeUpdate->getDescription(), $dataResponse['description']);
        $this->assertEquals($recipeUpdate->getIngredients(), $dataResponse['ingredients']);
        $this->assertEquals($recipeUpdate->getDirections(), $dataResponse['directions']);
        $this->assertEquals($recipeUpdate->getPrepTimeMin(), $dataResponse['prep_time_min']);
        $this->assertEquals($recipeUpdate->getCookTimeMin(), $dataResponse['cook_time_min']);
        $this->assertEquals($recipeUpdate->getServings(), $dataResponse['servings']);
        $this->assertEquals($recipeUpdate->getTags(), $dataResponse['tags']);
        $this->assertEquals($recipeUpdate->getAuthor()->jsonSerialize(), $dataResponse['author']);
        $this->assertEquals($recipeUpdate->getSourceUrl(), $dataResponse['source_url']);
    }

    /**
     * Test PUT petition that update data fail
     */
    public function testUpdateDataFail()
    {
        $recipe = $this->getRecipe($this->idFail);

        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->idFail;
        $response = $this->runApp('PUT', $urlPath, $recipe);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals(200, $response->getStatusCode());

        $this->assertContains('message', (string)$response->getBody());
        $this->assertContains('error', (string)$response->getBody());
        $this->assertContains('document_missing_exception', (string)$response->getBody());
    }

    /**
     * Test DELETE petition that delete data
     */
    public function testDeleteData()
    {
        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->id;
        $response = $this->runApp('DELETE', $urlPath);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(404, $response->getStatusCode());

        $this->assertContains('_index', (string)$response->getBody());
        $this->assertContains('_type', (string)$response->getBody());
        $this->assertContains('_id', (string)$response->getBody());
        $this->assertContains('_version', (string)$response->getBody());
        $this->assertContains('result', (string)$response->getBody());
        $this->assertContains('_shards', (string)$response->getBody());
        $this->assertContains('deleted', (string)$response->getBody());
        $this->assertContains('successful', (string)$response->getBody());
    }

    /**
     * Test DELETE petition that delete data fail
     */
    public function testDeleteDataFail()
    {
        $urlPath = $this->apiPath . $this->urlParams . '/' . $this->idFail;
        $response = $this->runApp('DELETE', $urlPath);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals(200, $response->getStatusCode());

        $this->assertContains('message', (string)$response->getBody());
        $this->assertContains('not_found', (string)$response->getBody());
    }

    /**
     * Test POST petition that search data
     */
    public function testSearchByMatch()
    {
        $data = ["title" => "Four"];
        $urlPath = $this->apiPath . $this->urlSerchParams . '/match';
        $response = $this->runApp('POST', $urlPath, $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());

        $dataResponse = json_decode($response->getBody(), true);

        if (count($dataResponse)>0) {
            $this->assertTrue(strpos($dataResponse[0]['title'], $data['title']) !== false);
            $this->assertGreaterThan(0, count($dataResponse));

            $this->assertContains('title', (string)$response->getBody());
            $this->assertContains('description', (string)$response->getBody());
            $this->assertContains('ingredients', (string)$response->getBody());
            $this->assertContains('directions', (string)$response->getBody());
            $this->assertContains('prep_time_min', (string)$response->getBody());
            $this->assertContains('cook_time_min', (string)$response->getBody());
            $this->assertContains('servings', (string)$response->getBody());
            $this->assertContains('tags', (string)$response->getBody());
            $this->assertContains('author', (string)$response->getBody());
            $this->assertContains('source_url', (string)$response->getBody());
        } else {
            $this->assertEquals(0, count($dataResponse));
        }
    }

    /**
     * Test POST petition that search all data
     */
    public function testSearchByMatchAll()
    {
        $urlPath = $this->apiPath . $this->urlSerchParams . '/match_all';
        $response = $this->runApp('POST', $urlPath);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());

        $dataResponse = json_decode($response->getBody(), true);

        if (count($dataResponse)>0) {
            $this->assertGreaterThan(0, count($dataResponse));

            $this->assertContains('title', (string)$response->getBody());
            $this->assertContains('description', (string)$response->getBody());
            $this->assertContains('ingredients', (string)$response->getBody());
            $this->assertContains('directions', (string)$response->getBody());
            $this->assertContains('prep_time_min', (string)$response->getBody());
            $this->assertContains('cook_time_min', (string)$response->getBody());
            $this->assertContains('servings', (string)$response->getBody());
            $this->assertContains('tags', (string)$response->getBody());
            $this->assertContains('author', (string)$response->getBody());
            $this->assertContains('source_url', (string)$response->getBody());
        } else {
            $this->assertEquals(0, count($dataResponse));
        }
    }

    /**
     * Test POST petition that search by query string
     */
    public function testSearchByQueryString()
    {
        $data = ["query" => "Four"];
        $urlPath = $this->apiPath . $this->urlSerchParams . '/query_string';
        $response = $this->runApp('POST', $urlPath, $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEquals(400, $response->getStatusCode());

        $dataResponse = json_decode($response->getBody(), true);

        if (count($dataResponse)>0) {
            $this->assertContains($data['query'], (string)$response->getBody());
            $this->assertGreaterThan(0, count($dataResponse));

            $this->assertContains('title', (string)$response->getBody());
            $this->assertContains('description', (string)$response->getBody());
            $this->assertContains('ingredients', (string)$response->getBody());
            $this->assertContains('directions', (string)$response->getBody());
            $this->assertContains('prep_time_min', (string)$response->getBody());
            $this->assertContains('cook_time_min', (string)$response->getBody());
            $this->assertContains('servings', (string)$response->getBody());
            $this->assertContains('tags', (string)$response->getBody());
            $this->assertContains('author', (string)$response->getBody());
            $this->assertContains('source_url', (string)$response->getBody());
        } else {
            $this->assertEquals(0, count($dataResponse));
        }
    }

    /**
     * Test POST petition that search with bad parameter
     */
    public function testSearchBadParameter()
    {
        $data = ["query" => "Four"];
        $urlPath = $this->apiPath . $this->urlSerchParams . '/bad';
        $response = $this->runApp('POST', $urlPath, $data);

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertNotEquals(200, $response->getStatusCode());
    }

    public function getRecipe($id) {
        $title = 'title Test';
        $description = 'description Test';
        $ingredients = ['Ingredient 1 test', 'Ingredient 2 test'];
        $directions = ['Direction 1 Test', 'Direction 2 Test'];
        $prepTimeMin = 0;
        $cookTimeMin = 0;
        $servings = 0;
        $tags = ['Tag 1 test', 'Tag 2 test'];
        $author = new Author('Test Name', 'http://urlTest.com');
        $sourceUrl = 'http://urlTest.com';
        $recipe = new Recipe($id, $title, $description, $ingredients, $directions, $prepTimeMin, $cookTimeMin, $servings, $tags, $author, $sourceUrl);

        return $recipe;
    }

    public function getRecipeUpdate($id) {
        $title = 'title Test Update';
        $description = 'description Test Update';
        $ingredients = ['Ingredient 1 test  Update', 'Ingredient 2 test  Update'];
        $directions = ['Direction 1 Test  Update', 'Direction 2 Test  Update'];
        $prepTimeMin = 1;
        $cookTimeMin = 1;
        $servings = 1;
        $tags = ['Tag 1 test Update', 'Tag 2 test Update'];
        $author = new Author('Test Name Update', 'http://urlTest.com Update');
        $sourceUrl = 'http://urlTest.com Update';
        $recipe = new Recipe($id, $title, $description, $ingredients, $directions, $prepTimeMin, $cookTimeMin, $servings, $tags, $author, $sourceUrl);

        return $recipe;
    }
}