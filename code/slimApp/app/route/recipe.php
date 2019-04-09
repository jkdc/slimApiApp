<?php

// API group
use App\Lib\Exception\QueryException;
use App\Service\RecipeService;
use Slim\Http\Request;
use Slim\Http\Response;


/**
 * @OA\Info(title="Slim API", version="0.1")
 */


$app->group('/api', function () use ($app) {

    //API version
    $app->group('/v1', function () use ($app) {

        //Recipe
        $app->group('/recipe', function () use ($app) {

            /**
             * @OA\Get(
             *   path="/api/v1/recipe/{id}",
             *   summary="Get recipe",
             *   @OA\Parameter(
             *       name="id", in="path", description="Recipe Id", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipe found",
             *     @OA\JsonContent(ref="#/components/schemas/recipe"),
             *   ),
             *   @OA\Response(
             *     response=404, description="Recipe not found"
             *   ),
             *   @OA\Response(
             *     response="default", description="an ""unexpected"" error"
             *   )
             * )
             */
            $app->get('/{id}', function (Request $request, Response $response, array $args) {
                $recipeService = new RecipeService($this->get('settings')['database']);

                $dataResult = $recipeService->getRecipe($this->get('settings')['tableSchemas']['recipe'], $args['id']);

                if ($dataResult instanceof QueryException) {
                    return $response->withJSON($dataResult->getErrorMessage(), $dataResult->getCode());
                }

                return $response->withJSON($dataResult, 200);
            });
            /**
             * @OA\Put(
             *   path="/api/v1/recipe/{id}",
             *   summary="Update recipe",
             *   @OA\Parameter(
             *       name="id", in="path", description="Recipe Id", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="title", in="header", description="Recipe title", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="description", in="header", description="Recipe description", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="ingredients", in="header", description="Recipe ingredients", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="directions", in="header", description="Recipe directions", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="prepTimeMin", in="header", description="Recipe prep time min", required=false,
             *       @OA\Schema(
             *           type="integer",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="cookTimeMin", in="header", description="Recipe cook time min", required=false,
             *       @OA\Schema(
             *           type="integer",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="servings", in="header", description="Recipe servings", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="tags", in="header", description="Recipe tags", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="author", in="header", description="Recipe author", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(ref="#/components/schemas/author")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="source_url", in="header", description="Recipe source url", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipe Update"
             *   ),
             *   @OA\Response(
             *     response=404, description="Recipe not found"
             *   ),
             *   @OA\Response(
             *     response="default", description="an ""unexpected"" error"
             *   )
             * )
             */

            $app->put('/{id}', function (Request $request, Response $response, array $args) {
                $recipeService = new RecipeService($this->get('settings')['database']);
                $dataResult = $recipeService->updateRecipe($this->get('settings')['tableSchemas']['recipe'], $args['id'], $request->getParams());

                if ($dataResult instanceof QueryException) {
                    return $response->withJSON($dataResult->getErrorMessage(), $dataResult->getCode());
                }

                return $response->withJSON($dataResult, 200);
            });

            /**
             * @OA\Post(
             *   path="/api/v1/recipe",
             *   summary="Create recipe",
             *   @OA\Parameter(
             *       name="id", in="path", description="Recipe Id", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="title", in="header", description="Recipe title", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="description", in="header", description="Recipe description", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="ingredients", in="header", description="Recipe ingredients", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="directions", in="header", description="Recipe directions", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="prepTimeMin", in="header", description="Recipe prep time min", required=false,
             *       @OA\Schema(
             *           type="integer",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="cookTimeMin", in="header", description="Recipe cook time min", required=false,
             *       @OA\Schema(
             *           type="integer",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="servings", in="header", description="Recipe servings", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="tags", in="header", description="Recipe tags", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(type="string")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="author", in="header", description="Recipe author", required=true,
             *       @OA\Schema(
             *           type="array",
             *           @OA\Items(ref="#/components/schemas/author")
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="source_url", in="header", description="Recipe source url", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipe created"
             *   ),
             *   @OA\Response(
             *     response="default", description="an ""unexpected"" error"
             *   )
             * )
             */
            $app->post('', function (Request $request, Response $response, array $args) {
                $recipeService = new RecipeService($this->get('settings')['database']);
                $dataResult = $recipeService->insertRecipe($this->get('settings')['tableSchemas']['recipe'], $request->getParams());

                if ($dataResult instanceof QueryException) {
                    return $response->withJSON($dataResult->getErrorMessage(), $dataResult->getCode());
                }

                return $response->withJSON($dataResult, 200);
            });

            /**
             * @OA\Delete(
             *   path="/api/v1/recipe/{id}",
             *   summary="Delete recipe",
             *   @OA\Parameter(
             *       name="id", in="path", description="Recipe Id", required=true,
             *       @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipe Delete"
             *   ),
             *   @OA\Response(
             *     response=404, description="Recipe not found"
             *   ),
             *   @OA\Response(
             *     response="default", description="an ""unexpected"" error"
             *   )
             * )
             */
            $app->delete('/{id}', function (Request $request, Response $response, array $args) {
                $recipeService = new RecipeService($this->get('settings')['database']);
                $dataResult = $recipeService->deleteRecipe($this->get('settings')['tableSchemas']['recipe'], $args['id']);

                if ($dataResult instanceof QueryException) {
                    return $response->withJSON(($dataResult->getErrorMessage()), $dataResult->getCode());
                }

                return $response->withJSON($dataResult, 200);
            });


            /**
             * @OA\Post(
             *   path="/api/v1/recipe/search/{filter}",
             *   summary="get recipe",
             *   @OA\Parameter(
             *       name="filter",
             *       in="path",
             *       description="Kind filter of search",
             *       required=true,
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipes found",
             *     @OA\JsonContent(ref="#/components/schemas/recipe"),
             *   ),
             *   @OA\Response(
             *     response="default", description="an ""unexpected"" error"
             *   )
             * )
             */
            $app->post('/search/{filter:query_string|match|match_all}', function (Request $request, Response $response, array $args) {
                $recipeService = new RecipeService($this->get('settings')['database']);
                $dataResult = $recipeService->searchRecipe($this->get('settings')['tableSchemas']['recipe'], $args['filter'], $request->getParams());

                if ($dataResult instanceof QueryException) {
                    return $response->withJSON($dataResult->getErrorMessage(), $dataResult->getCode());
                }

                return $response->withJSON($dataResult, 200);
            });

        });
    });
});
