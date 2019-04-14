<?php

// API group
use App\Lib\Exception\QueryException;
use App\Service\RecipeService;
use Slim\Http\Request;
use Slim\Http\Response;



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
             *   @OA\RequestBody(
             *     required=true,
             *     @OA\JsonContent(ref="#/components/schemas/recipe"),
             *     @OA\MediaType(
             *       mediaType="application/json",
             *       @OA\Schema(
             *           ref="#/components/schemas/recipe"
             *       ),
             *     ),
             *    ),
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
             *   @OA\RequestBody(
             *     required=true,
             *     @OA\JsonContent(ref="#/components/schemas/recipe"),
             *     @OA\MediaType(
             *       mediaType="application/json",
             *       @OA\Schema(
             *           ref="#/components/schemas/recipe"
             *       ),
             *     ),
             *    ),
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
             *        @OA\Schema(
             *           type="string",
             *        ),
             *   ),
             *   @OA\Parameter(
             *       name="query",
             *       in="query",
             *       description="Data to search",
             *       required=false,
             *        @OA\Schema(
             *           type="string",
             *        ),
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
