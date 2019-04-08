<?php


use App\Lib\Exception\QueryException;
use App\Service\RecipeService;
use Slim\Http\Request;
use Slim\Http\Response;


// Routes

/**
 * @OA\Info(title="Slim API", version="0.1")
 */

// API group
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
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipe found"
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
             *   ),
             *   @OA\Parameter(
             *       name="title", in="formData", description="Recipe title", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="description", in="formData", description="Recipe description", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="ingredients", in="formData", description="Recipe ingredients, required=true,
             *   ),
             *   @OA\Parameter(
             *       name="directions", in="formData", description="Recipe directions", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="prepTimeMin", in="formData", description="Recipe prep time min", required=false,
             *   ),
             *   @OA\Parameter(
             *       name="cookTimeMin", in="formData", description="Recipe cook time min", required=false,
             *   ),
             *   @OA\Parameter(
             *       name="servings", in="formData", description="Recipe servings", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="tags", in="formData", description="Recipe tags", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="author", in="formData", description="Recipe author", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="source_url", in="formData", description="Recipe source url", required=true,
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
             *       name="id", in="formData", description="Recipe Id", required=false,
             *   ),
             *   @OA\Parameter(
             *       name="title", in="formData", description="Recipe title", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="description", in="formData", description="Recipe description", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="ingredients", in="formData", description="Recipe ingredients, required=true,
             *   ),
             *   @OA\Parameter(
             *       name="directions", in="formData", description="Recipe directions", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="prepTimeMin", in="formData", description="Recipe prep time min", required=false,
             *   ),
             *   @OA\Parameter(
             *       name="cookTimeMin", in="formData", description="Recipe cook time min", required=false,
             *   ),
             *   @OA\Parameter(
             *       name="servings", in="formData", description="Recipe servings", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="tags", in="formData", description="Recipe tags", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="author", in="formData", description="Recipe author", required=true,
             *   ),
             *   @OA\Parameter(
             *       name="source_url", in="formData", description="Recipe source url", required=true,
             *   ),
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
             *       default= {query_string , match, match_all}
             *       description="Kind filter of search",
             *       required=true,
             *   ),
             *   @OA\Response(
             *     response=200, description="Recipes found"
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
/**
 * @OA\Get(
 *   path="/swagger/doc",
 *   summary="Get swagger documentacion",
 *   @OA\Response(
 *     response=200,
 *     description="Get Swagger doc"
 *   ),
 *   @OA\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   )
 * )
 */
$app->get('/swagger/doc', function (Request $request, Response $response, array $args) {
    $openapi = \OpenApi\scan('/home/app/slimApp/', ['exclude' => 'vendor']);
    header('Content-Type: application/x-yaml');
    echo $openapi->toYaml();
});

